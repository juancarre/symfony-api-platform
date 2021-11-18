<?php


namespace Mailer\Messenger\Handler;


use Mailer\Messenger\Message\RequestResetPasswordMessage;
use Mailer\Service\Mailer\ClientRoute;
use Mailer\Service\Mailer\MailerService;
use Mailer\Templating\TwigTemplate;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RequestResetPasswordMessageHandler implements MessageHandlerInterface
{
    /**
     * @var MailerService
     */
    private MailerService $mailerService;
    /**
     * @var string
     */
    private string $host;

    /**
     * RequestResetPasswordMessageHandler constructor.
     * @param MailerService $mailerService
     * @param string $host
     */
    public function __construct(MailerService $mailerService, string $host)
    {
        $this->mailerService = $mailerService;
        $this->host = $host;
    }

    public function __invoke(RequestResetPasswordMessage $message): void
    {

        $payload = [
            'url' => sprintf(
                '%s%s?uid=%s&rpt=%s',
                $this->host,
                ClientRoute::RESET_PASSWORD,
                $message->getId(),
                $message->getResetPasswordToken()
            )
        ];

        $this->mailerService->send($message->getEmail(), TwigTemplate::REQUEST_RESET_PASSWORD, $payload);
    }
}