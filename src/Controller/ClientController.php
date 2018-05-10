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
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
     * @Rest\Get(
     *    path = "/api/clients",
     *    name = "client_list",
     * )
     * @Rest\View
     */
    public function listAction()
    {
        $user = $this->getUser();
        $clients = $this->entityManager->getRepository(Client::class)->findBy(array('user' => $user));

        return $this->getResponse($clients, Response::HTTP_OK, ['client_list']);
    }

    /**
     * @Rest\Get(
     *    path = "/api/clients/{id}",
     *    name = "client_show",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function showAction(Client $client = null)
    {
        if ($client === null || $client->getUser() !== $this->getUser()) {
            throw new NoClientFoundException('Nous n\'avons pas trouvé ce client.');
        }

        return $this->getResponse($client, Response::HTTP_OK, ['client_detail']);
    }

    /**
     * @Rest\Post(
     *    path = "/api/clients",
     *    name = "client_create",
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("client", converter="fos_rest.request_body")
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
     * @Rest\Delete(
     *    path = "/api/clients/{id}",
     *    name = "client_delete",
     * )
     * @Rest\View(StatusCode = 200)
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