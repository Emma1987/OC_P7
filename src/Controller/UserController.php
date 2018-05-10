<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\BilemoController;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\TokenManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Exception\InvalidUserException;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @SWG\Tag(name="User")
 */
class UserController extends BilemoController
{
    /**
     * Entity Manager
     */
    protected $entityManager;

    /**
     * Token Manager
     */
    protected $tokenManager;

    public function __construct(EntityManagerInterface $entityManager, TokenManager $tokenManager)
    {
        $this->entityManager = $entityManager;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Login action
     * 
     * @Rest\Post(
     *    path = "/login",
     *    name = "api_login",
     * )
     * @Rest\View
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="body",
     *     description="Login username",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="body",
     *     description="Login password",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Login success, return the token to use with each request to the API"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Bad credentials"
     * )
     */
    public function loginAction()
    {
        $user = $this->getUser();
        return $token = $this->tokenManager->getJWT($user);
    }

    /**
     * Register action
     * 
     * @Rest\Post(
     *     path = "/register", 
     *     name = "api_register"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="body",
     *     description="Account username",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="body",
     *     description="Account email",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="body",
     *     description="Account password",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Register successfully"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad data sent, some fields are not correct"
     * )
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
     * Get the current user account
     * 
     * @Rest\Get(
     *    path = "/api/users/{id}",
     *    name = "api_user_show",
     * )
     * @Rest\View
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer jwt",
     *     description="Authorization token required to access resources"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Get the detail of the current user with success"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Need a valide token to access this request"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No user found"
     * )
     */
    public function showAction(User $user = null)
    {
        if ($user === null || $user->getId() !== $this->getUser()->getId()) {
            throw new InvalidUserException('L\'url semble incorrecte.');
        }

        return $this->getResponse($user, Response::HTTP_OK, ['user_detail', 'client_list']);
    }	
}