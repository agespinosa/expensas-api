<?php

declare(strict_types=1);

namespace App\Security\Core\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username): UserInterface
    {
        return $this->findUser($username);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of [%s] are not supported', get_class($user))
            );
        }

        return $this->findUser($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

    private function findUser(string $username): User
    {
        $user = $this->userRepository->findOneByEmail($username);
        if (!$user) {
            throw new UsernameNotFoundException(printf('User with email [%s] not found', $username));
        }

        return $user;
    }
}
