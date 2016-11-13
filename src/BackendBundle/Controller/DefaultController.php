<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$userRepo = $em->getRepository("BackendBundle:User");

    	$user = $userRepo->find(1);

    	echo "Bienvenido " . $user->getName(). " " . $user->getSurname();
    	var_dump($user);
    	die();

        return $this->render('BackendBundle:Default:index.html.twig');
    }
}
