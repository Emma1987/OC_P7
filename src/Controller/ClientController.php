<?php

namespace App\Controller;

use App\Entity\Client;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $clients = $this->entityManager->getRepository(Client::class)->findAll();

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
        $data = $this->get('jms_serializer')->serialize($client, 'json', SerializationContext::create()->setGroups(array('detail')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}