<?php


namespace Mailer\Messenger\Handler;


use Mailer\Messenger\Message\GroupRequestMessage;
use Mailer\Service\Mailer\ClientRoute;
use Mailer\Service\Mailer\MailerService;
use Mailer\Templating\TwigTemplate;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GroupRequestMessageHandler implements MessageHandlerInterface
{
    /**
     * @var MailerService
     */
    private MailerService $mailerService;
    private string $host;

    /**
     * GroupRequestMessageHandler constructor.
     */
    public function __construct(MailerService $mailerService, string $host)
    {
        $this->mailerService = $mailerService;
        $this->host = $host;
    }

    public function __invoke(GroupRequestMessage $message): void
    {
        $payload = [
            'requestedName' => $message->getRequestedName(),
            'groupName' => $message->getGroupName(),
            'url' => sprintf(
                '%s%s?groupId=%s&userId=%s&token=%s',
                $this->host,
                ClientRoute::GROUP_REQUEST,
                $message->getGroupId(),
                $message->getUserId(),
                $message->getToken(),
            )
        ];

        $this->mailerService->send($message->getReceiverEmail(), TwigTemplate::GROUP_REQUEST, $payload);
    }
}