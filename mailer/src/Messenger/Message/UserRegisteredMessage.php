<?php


namespace Mailer\Messenger\Message;


class UserRegisteredMessage
{

    /**
     * UserRegisteredMessage constructor.
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $token
     */
    public function __construct(string $id, string $name, string $email, string $token)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

}