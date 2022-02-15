<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Uid\Uuid;

class ContactRequest
{
    private string $id;
    private User $owner;
    private string $email;
    private bool $active;
    private ?string $contactReason;
    private ?string $message;
    private ?string $requieredSkills;
    private bool $joinMyTeam;
    private bool $orderProject;
    private ?\DateTime $meetingDate;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    /**
     * ContactRequest constructor.
     * @param User $owner
     * @param string $email
     */
    public function __construct(User $owner, string $email)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->email = $email;
        $this->owner = $owner;
        $this->active = true;
        $this->contactReason = null;
        $this->message = null;
        $this->requieredSkills = null;
        $this->joinMyTeam = false;
        $this->orderProject = false;
        $this->meetingDate = null;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string|null
     */
    public function getContactReason(): ?string
    {
        return $this->contactReason;
    }

    /**
     * @param string|null $contactReason
     */
    public function setContactReason(?string $contactReason): void
    {
        $this->contactReason = $contactReason;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getRequieredSkills(): ?string
    {
        return $this->requieredSkills;
    }

    /**
     * @param string|null $requieredSkills
     */
    public function setRequieredSkills(?string $requieredSkills): void
    {
        $this->requieredSkills = $requieredSkills;
    }

    /**
     * @return bool
     */
    public function isJoinMyTeam(): bool
    {
        return $this->joinMyTeam;
    }

    /**
     * @param bool $joinMyTeam
     */
    public function setJoinMyTeam(bool $joinMyTeam): void
    {
        $this->joinMyTeam = $joinMyTeam;
    }

    /**
     * @return bool
     */
    public function isOrderProject(): bool
    {
        return $this->orderProject;
    }

    /**
     * @param bool $orderProject
     */
    public function setOrderProject(bool $orderProject): void
    {
        $this->orderProject = $orderProject;
    }

    /**
     * @return \DateTime|null
     */
    public function getMeetingDate(): ?\DateTime
    {
        return $this->meetingDate;
    }

    /**
     * @param \DateTime|null $meetingDate
     */
    public function setMeetingDate(?\DateTime $meetingDate): void
    {
        $this->meetingDate = $meetingDate;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->owner->getId() === $user->getId();
    }

}

