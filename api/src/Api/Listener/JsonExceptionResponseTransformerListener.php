<?php


namespace App\Api\Listener;


use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Constraints\Time;

class JsonExceptionResponseTransformerListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterfaceface){
            $data = [
                'class' => get_class($exception),
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];

            $event->setResponse($this->prepareResponse($data, $data['code']));
        }
    }

    private function prepareResponse(array $data, int $statusCode): JsonResponse
    {
        $response = new JsonResponse($data, $statusCode);
        $response->headers->set('Server-Time', \time());
        $response->headers->set('X-Error-Code', $statusCode);

        return $response;
    }
}