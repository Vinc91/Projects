<?php

namespace PW\ProgresSiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProgresSiesController extends Controller
{
    public function indexAction()
    {
        return $this->render('PWProgresSiesBundle:ProgresSies:index.html.twig');
    }

    public function viewAction($id)
    {

    return $this->render('PWProgresSiesBundle:ProgresSies:view.html.twig', array('id'  => $id));
    }

    public function addAction()
    {

    return $this->render('PWProgresSiesBundle:ProgresSies:add.html.twig');
	}

	public function menuAction()
    {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Walking Dead'),
      array('id' => 5, 'title' => 'Game of Thrones'),
      array('id' => 9, 'title' => 'Breaking Bad')
    );

    return $this->render('PWProgresSiesBundle:ProgresSies:menu.html.twig', array(
      'listAdverts' => $listAdverts
    ));
	}

}