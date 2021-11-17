<?php


namespace App\Messenger\Message;


class GroupRequestMessage
{
    private string $groupId;
    private string $userId;
    private string $token;
    private string $requestedName;
    private string $groupName;
    private string $receiverEmail;

    /**
     * GroupRequestMessage constructor.
     */
    public function __construct(
        string $groupId,
        string $userId,
        string $token,
        string $requestedName,
        string $groupName,
        string $receiverEmail
    )
    {
        $this->groupId = $groupId;
        $this->userId = $userId;
        $this->token = $token;
        $this->requestedName = $requestedName;
        $this->groupName = $groupName;
        $this->receiverEmail = $receiverEmail;
    }

    /**
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->groupId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getRequestedName(): string
    {
        return $this->requestedName;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @return string
     */
    public function getReceiverEmail(): string
    {
        return $this->receiverEmail;
    }


}