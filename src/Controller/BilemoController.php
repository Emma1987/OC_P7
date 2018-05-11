<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;

class BilemoController extends FOSRestController
{
    /**
     * Serialize the response to send with serialization group
     * 
     * @param $data Data to serialize
     * @param $groups Serialization group
     */
    public function getResponse($data, $statusCode, $groups = [])
    {
        $serialize = $this->get('jms_serializer')->serialize($data, 'json', SerializationContext::create()->setGroups($groups));

        $response = new Response($serialize);
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($statusCode);

        return $response;
    }
}