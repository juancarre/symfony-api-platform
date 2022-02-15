<?php


namespace App\Security\Authorization\Voter;


use App\Entity\ContactRequest;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ContactRequestVoter extends Voter
{
    public const CONTACT_REQUEST_READ = 'CONTACT_REQUEST_READ';
    public const CONTACT_REQUEST_UPDATE = 'CONTACT_REQUEST_UPDATE';
    public const CONTACT_REQUEST_DELETE = 'CONTACT_REQUEST_DELETE';
    public const CONTACT_REQUEST_CREATE = 'CONTACT_REQUEST_CREATE';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, $this->supportedAttributes(), true);
    }

    /**
     * @param ContactRequest|null $subject
     * @return bool|void
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /** @var User $tokenUser */
        $tokenUser = $token->getUser();

        if ($attribute === self::CONTACT_REQUEST_CREATE) {
            return true;
        }

        if (in_array($attribute, [self::CONTACT_REQUEST_READ, self::CONTACT_REQUEST_UPDATE, self::CONTACT_REQUEST_DELETE], true)) {
            return true;
        }

        return false;
    }

    private function supportedAttributes(): array
    {
        return [
            self::CONTACT_REQUEST_READ,
            self::CONTACT_REQUEST_UPDATE,
            self::CONTACT_REQUEST_DELETE,
            self::CONTACT_REQUEST_CREATE
        ];
    }
}