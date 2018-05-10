<?php

namespace App\Controller;

use App\Entity\Mobile;
use App\Controller\BilemoController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @SWG\Tag(name="Mobile")
 */
class MobileController extends BilemoController
{
    /**
     * Get the mobiles list
     * 
     * @Rest\Get(
     *    path = "/api/mobiles",
     *    name = "mobile_list",
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
     *     description="Get the mobiles list with success"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Need a valid token to access this request"
     * )
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $mobiles = $entityManager->getRepository(Mobile::class)->findAll();

        return $this->getResponse($mobiles, Response::HTTP_OK, ['mobile_list']);
    }

    /**
     * Get the detail of a mobile
     * 
     * @Rest\Get(
     *    path = "/api/mobiles/{id}",
     *    name = "mobile_show",
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
     *     description="The unique mobile identifier",
     *     required=true
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Get the detail of a mobile with success"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Need a valide token to access this request"
     * )
     */
    public function showAction(Mobile $mobile)
    {
        return $this->getResponse($mobile, Response::HTTP_OK, ['mobile_detail']);
    }
}