<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @method string getUserIdentifier()
 */
class User implements UserInterface
{
    private string $id;
    private string $name;
    private string $email;
    private ?string $password;
    private ?string $avatar;
    private ?string $token;
    private ?string $resetPasswordToken;
    private bool $active;
    private ?string $companyName;
    private ?string $phoneNumber;
    private ?string $companyWeb;
    private ?string $userType;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    private Collection $groups;
    private Collection $categories;
    private Collection $movements;
    private Collection $requests;

    /**
     * User constructor.
     * @param string $name
     * @param string $email
     */
    public function __construct(string $name, string $email)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->setEmail($email);
        $this->password = null;
        $this->avatar = null;
        $this->token = \sha1(\uniqid());
        $this->resetPasswordToken = null;
        $this->active = false;
        $this->companyName = null;
        $this->phoneNumber = null;
        $this->companyWeb = null;
        $this->userType = null;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
        $this->groups = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->movements = new ArrayCollection();
        $this->requests = new ArrayCollection();

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (!\filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw new \LogicException('Invalid email');
        }

        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken): void
    {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     */
    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getCompanyWeb(): ?string
    {
        return $this->companyWeb;
    }

    /**
     * @param string|null $companyWeb
     */
    public function setCompanyWeb(?string $companyWeb): void
    {
        $this->companyWeb = $companyWeb;
    }

    /**
     * @return string|null
     */
    public function getUserType(): ?string
    {
        return $this->userType;
    }

    /**
     * @param string|null $userType
     */
    public function setUserType(?string $userType): void
    {
        $this->userType = $userType;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getRoles()
    {
        return [];
    }

    public function getSalt(): void
    {
    }

    public function eraseCredentials(): void
    {
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function equals(User $user): bool
    {
        return $this->id === $user->getId();
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): void
    {
        if ($this->groups->contains($group)) {
            return;
        }

        $this->groups->add($group);
    }

    public function removeGroup(Group $group): void
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }
    }

    public function isMemberOfGroup(Group $group): bool
    {
        return $this->groups->contains($group);
    }

    // Contact Requests
    /**
     * @return Collection|ContactRequest[]
     */
    public function getContactRequests(): Collection
    {
        return $this->requests;
    }

    public function addContactRequest(ContactRequest $contactRequest): void
    {
        if ($this->requests->contains($contactRequest)) {
            return;
        }

        $this->requests->add($this->requests);
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @return Collection|Movement[]
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }
}
