<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class UserController extends FOSRestController
{
    /**
     * Entity Manager
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\Post(
     *    path = "/login",
     *    name = "api_login",
     * )
     * @Rest\View
     */
    public function loginAction()
    {
    }

    /**
     * @Rest\Post(
     *     path = "/register", 
     *     name = "api_register"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function createClientAction(User $user, UserPasswordEncoderInterface $passwordEncoder, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = "Les données envoyées sont incorrectes, merci de corriger les points suivants : ";
            foreach ($violations as $violation) {
                $message .= sprintf("Champs %s : %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);    
        }

        $this->entityManager->persist($user);

        $password = $passwordEncoder->encodePassword($user, $user->getPassword());
        $user->__construct();
        $user->setPassword($password);

        $this->entityManager->flush();
    }

    /**
     * @Rest\Get(
     *    path = "/api/users/{id}",
     *    name = "api_user_show",
     * )
     * @Rest\View
     */
    public function showAction(User $user)
    {
        return $user;
    }	
}