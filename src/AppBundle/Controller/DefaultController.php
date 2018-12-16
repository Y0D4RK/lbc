<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/api", name="api")
     * @Method("GET")
     */
    public function apiAction(Request $request)
    {
        return new JsonResponse(["status"=>"200", "message"=>"HTTP_OK"]);
//        // retrieve the user connected from token jwt
//        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $data = array("user" => $user);
//        $view = $this->view($data, 200);
//        return $this->handleView($view);
    }
}
