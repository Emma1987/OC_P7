<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Exception\NoClientFoundException;

class ClientController extends FOSRestController
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
    public function listAction(Request $request)
    {
        $user = $this->getUser();
        $clients = $this->entityManager->getRepository(Client::class)->findBy(array('user' => $user));

        $data = $this->get('jms_serializer')->serialize($clients, 'json', SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Get(
     *    path = "/api/clients/{id}",
     *    name = "client_show",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function showAction(Request $request, Client $client)
    {
        if ($client->getUser() !== $this->getUser() || empty($client)) {
            throw new NoClientFoundException('Nous n\'avons pas trouvé ce client.');
        }

        $data = $this->get('jms_serializer')->serialize($client, 'json', SerializationContext::create()->setGroups(array('detail')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Rest\Post(
     *    path = "/api/clients",
     *    name = "client_create",
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("client", converter="fos_rest.request_body")
     */
    public function createAction(Request $request, Client $client, ConstraintViolationList $violations)
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

        return $this->view(
            $client, 
            Response::HTTP_CREATED, 
            ['Location' => $this->generateUrl('client_show', ['id' => $client->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]
        );
    }

    /**
     * @Rest\Delete(
     *    path = "/api/clients/{id}",
     *    name = "client_delete",
     * )
     * @Rest\View(StatusCode = 200)
     */
    public function deleteAction(Request $request, Client $client)
    {
        if ($client->getUser() !== $this->getUser() || empty($client)) {
            throw new NoClientFoundException('Nous n\'avons pas trouvé ce client.');
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}