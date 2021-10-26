<?php


namespace App\Api\ArgumentResolver;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserArgumentResolver implements ArgumentValueResolverInterface
{
    /**
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;


    /**
     * UserArgumentResolver constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param UserRepository $userRepository
     */
    public function __construct(TokenStorageInterface $tokenStorage, UserRepository $userRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (User::class !== $argument->getType()) {
            return false;
        }

        $token = $this->tokenStorage->getToken();
        if (!$token instanceof TokenInterface) {
            return false;
        }

        return $token->getUser() instanceof User;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield $this->userRepository->findOneByEmailOrFail($this->tokenStorage->getToken()->getUser()->getEmail());
    }

}