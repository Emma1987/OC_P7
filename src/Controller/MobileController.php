<?php

namespace App\Controller;

use App\Entity\Mobile;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MobileController extends FOSRestController
{
	/**
	 * @Rest\Get(
	 * 	  path = "/api/mobiles",
	 * 	  name = "mobile_list",
	 * )
	 * @Rest\View
	 */
	public function listAction(Request $request)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$mobiles = $entityManager->getRepository(Mobile::class)->findAll();

		$data = $this->get('jms_serializer')->serialize($mobiles, 'json', SerializationContext::create()->setGroups(array('list')));

		$response = new Response($data);
		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}

	/**
	 * @Rest\Get(
	 * 	  path = "/api/mobiles/{id}",
	 * 	  name = "mobile_show",
	 * 	  requirements = {"id"="\d+"}
	 * )
	 * @Rest\View
	 */
	public function showAction(Request $request, Mobile $mobile)
	{
		$data = $this->get('jms_serializer')->serialize($mobile, 'json', SerializationContext::create()->setGroups(array('detail')));

		$response = new Response($data);
		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}
}