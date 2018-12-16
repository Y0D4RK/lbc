<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class DefaultController extends FOSRestController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Return the landing page"
     * )
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/api", name="api", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Return the index api"
     * )
     * @Security(name="Bearer")
     */
    public function apiAction(Request $request)
    {
//        return new JsonResponse(["status"=>"200", "message"=>"HTTP_OK"]);
        // retrieve the user connected from token jwt
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $data = array("user" => $user);
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
}
