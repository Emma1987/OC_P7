<?php

namespace App\Controller;

use App\Entity\Mobile;
use App\Controller\BilemoController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class MobileController extends BilemoController
{
    /**
     * @Rest\Get(
     *    path = "/api/mobiles",
     *    name = "mobile_list",
     * )
     * @Rest\View
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $mobiles = $entityManager->getRepository(Mobile::class)->findAll();

        return $this->getResponse($mobiles, Response::HTTP_OK, ['mobile_list']);
    }

    /**
     * @Rest\Get(
     *    path = "/api/mobiles/{id}",
     *    name = "mobile_show",
     *    requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function showAction(Mobile $mobile)
    {
        return $this->getResponse($mobile, Response::HTTP_OK, ['mobile_detail']);
    }
}