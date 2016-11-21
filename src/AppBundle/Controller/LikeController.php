<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use BackendBundle\Entity\User;
use BackendBundle\Entity\Publication;
use BackendBundle\Entity\Like;

class LikeController extends Controller{
	
	private $session;

	public function __construct(){
		$this->session = new Session();
	}

	public function likeAction($id=null){

		$em = $this->getDoctrine()->getManager();
		$publications_repo = $em->getRepository("BackendBundle:Publication");
		$publication = $publications_repo->find($id);

		$user = $this->getUser();

		$like = new Like();
		$like->setUser($user);
		$like->setPublication($publication);

		$em->persist($like);
		$flush = $em->flush();

		if($flush == null){
			$notification = $this->get('app.notification_service');
			$notification->set($publication->getUser(), 'like', $user->getId(), $publication->getId());
			
			$status = "Te gusta esta publicacion";
		}else{
			$status = "Ups... Algo ha ido mal";
		}
		
		return new Response($status);
	}

	public function unlikeAction($id=null){
		
		$user = $this->getUser();

		$em = $this->getDoctrine()->getManager();
		$like_repo = $em->getRepository("BackendBundle:Like");
		$like = $like_repo->findOneBy(array(
			"user" => $user,
			"publication" => $id
		));

		$em->remove($like);
		$flush = $em->flush();

		if($flush == null){
			$status = "Ya no te gusta esta publicacion";
		}else{
			$status = "Ups... Algo ha ido mal";
		}
		
		return new Response($status);
	}

	public function likesAction(Request $request, $nickname){

		$em = $this->getDoctrine()->getManager();

		if($nickname != null){
			$user_repo = $em->getRepository("BackendBundle:User");
			$user = $user_repo->findOneBy(array("nick" => $nickname));
		}else{
			$user = $this->getUser();
		}

		if(empty($user) || !is_object($user)){
			return $this->redirect($this->generateUrl('home_publications'));
		}

		$user_id = $user->getId();
		$dql = "SELECT l FROM BackendBundle:Like l WHERE l.user = $user_id ORDER BY l.id DESC";
		$query = $em->createQuery($dql);

		$paginator = $this->get("knp_paginator");
		$likes = $paginator->paginate(
						$query, 
						$request->query->getInt('page', 1),
						5		//Usuarios por página
					);

		return $this->render('AppBundle:Like:likes.html.twig',
			array(
				"user"  	 => $user,
				"pagination" => $likes
				)
			);
	}








}