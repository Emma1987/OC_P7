<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use App\Exception\InvalidTokenException;
use App\Entity\User as APIUser;
use App\Service\TokenManager;
use App\Repository\UserRepository;

class ApiKeyUserProvider implements UserProviderInterface
{
    private $userRepository;
    private $tokenManager;

    public function __construct(UserRepository $userRepository, TokenManager $tokenManager)
    {
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
    }

    public function getUsernameForApiKey($apiKey)
    {
        $userInformations = $this->tokenManager->decodeJWT($apiKey);

        return $username = $userInformations['username'];
    }

    public function loadUserByUsername($username)
    {
        return $user = $this->userRepository->findOneByUsername(array('username' => $username));
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return APIUser::class === $class;
    }
}