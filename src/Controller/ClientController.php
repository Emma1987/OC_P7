<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Controller\BilemoController;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;
use App\Exception\NoClientFoundException;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @SWG\Tag(name="Client")
 */
class ClientController extends BilemoController
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
     * Get the clients list
     * 
     * @Rest\Get(
     *    path = "/api/clients",
     *    name = "client_list",
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
     *     description="Get the clients list with success"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Need a valid token to access this request"
     * )
     */
    public function listAction()
    {
        $user = $this->getUser();
        $clients = $this->entityManager->getRepository(Client::class)->findBy(array('user' => $user));

        return $this->getResponse($clients, Response::HTTP_OK, ['client_list']);
    }

    /**
     * Get the detail of a client
     * 
     * @Rest\Get(
     *    path = "/api/clients/{id}",
     *    name = "client_show",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @Cache(expires="+1 hour", public=true)
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer jwt",
     *     description="Authorization token required to access resources"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The unique client identifier",
     *     required=true
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Get the detail of a client with success"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Need a valide token to access this request"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No client found"
     * )
     */
    public function showAction(Client $client = null)
    {
        if ($client === null || $client->getUser() !== $this->getUser()) {
            throw new NoClientFoundException('Nous n\'avons pas trouvé ce client.');
        }

        return $this->getResponse($client, Response::HTTP_OK, ['client_detail']);
    }

    /**
     * Create a new client
     * 
     * @Rest\Post(
     *    path = "/api/clients",
     *    name = "client_create",
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("client", converter="fos_rest.request_body")
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer jwt",
     *     description="Authorization token required to create resources"
     * )
     * @SWG\Parameter(
     *     name="firstname",
     *     in="body",
     *     description="client's firstname",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="lastname",
     *     in="body",
     *     description="client's lastname",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="address",
     *     in="body",
     *     description="client's address",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="post_code",
     *     in="body",
     *     description="client's post code",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="city",
     *     in="body",
     *     description="client's city",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="phone_number",
     *     in="body",
     *     description="client's phone number",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="body",
     *     description="client's email",
     *     required=true,
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Response(
     *     response=201,
     *     description="New client create successfully",
     *     @Model(type=Client::class)
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad data sent, some fields are not correct"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Need a valid token to access this request"
     * )
     */
    public function createAction(Client $client, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = "Les données envoyées sont incorrectes, merci de corriger les points suivants : ";
            foreach ($violations as $violation) {
                $message .= sprintf("Champs %s : %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);    
        }

        $this->entityManager->persist($client);
        $user = $this->getUser();
        $user->addClient($client);
        $this->entityManager->flush();

        return $this->getResponse($client, Response::HTTP_CREATED, ['client_detail']);
    }

    /**
     * Delete a client
     * 
     * @Rest\Delete(
     *    path = "/api/clients/{id}",
     *    name = "client_delete",
     * )
     * @Rest\View(StatusCode = 200)
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer jwt",
     *     description="Authorization token required to delete resources"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The unique client identifier",
     *     required=true
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Client deleted successfully"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Need a valide token to access this request"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No client found"
     * )
     */
    public function deleteAction(Client $client = null)
    {
        if ($client === null || $client->getUser() !== $this->getUser()) {
            throw new NoClientFoundException('Nous n\'avons pas trouvé ce client.');
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}