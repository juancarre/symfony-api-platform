<?php


namespace App\Security\Authorization\Voter;


use App\Entity\Movement;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MovementVoter extends Voter
{
    public const MOVEMENT_READ = 'MOVEMENT_READ';
    public const MOVEMENT_UPDATE = 'MOVEMENT_UPDATE';
    public const MOVEMENT_DELETE = 'MOVEMENT_DELETE';
    public const MOVEMENT_CREATE = 'MOVEMENT_CREATE';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, $this->supportedAttributes(), true);
    }

    /**
     * @param Movement|null $subject
     * @return bool|void
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /** @var User $tokenUser */
        $tokenUser = $token->getUser();

        if ($attribute === self::MOVEMENT_CREATE) {
            return true;
        }

        if (null !== $group = $subject->getGroup()) {
            if (in_array($attribute, [self::MOVEMENT_READ, self::MOVEMENT_UPDATE, self::MOVEMENT_DELETE], true)) {
                return $tokenUser->isMemberOfGroup($group);
            }
        }

        if (in_array($attribute, [self::MOVEMENT_READ, self::MOVEMENT_UPDATE, self::MOVEMENT_DELETE], true)) {
            return $subject->isOwnedBy($tokenUser);
        }

        return false;
    }

    private function supportedAttributes(): array
    {
        return [
            self::MOVEMENT_READ,
            self::MOVEMENT_UPDATE,
            self::MOVEMENT_DELETE,
            self::MOVEMENT_CREATE
        ];
    }
}