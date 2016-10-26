<?php

namespace PW\ProgresSiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PW\ProgresSiesBundle\Entity\Serie;
use PW\ProgresSiesBundle\Entity\Image;
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

    	$repository= $this->getDoctrine()->getManager()->getRepository('PWProgresSiesBundle:Serie');
    	$serie = $repository->find($id);

    return $this->render('PWProgresSiesBundle:ProgresSies:view.html.twig', array('serie'  => $serie));
    }

    public function viewallAction()
    {

    return $this->render('PWProgresSiesBundle:ProgresSies:viewall.html.twig');
    }

    public function addAction(Request $request)
    {
    	$serie = new Serie();
    	$serie->setTitre("Walking Dead");
    	$serie->setCreateur("MArivin gay");
    	$serie->setNbSaisons(7);
    
    	$image= new Image();
    	$image->setUrl('http://fr.web.img5.acsta.net/medias/nmedia/18/78/35/82/20303823.jpg');
    	$image->setAlt('Walking Dead');

    	$serie->setImage($image);

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($serie);
    	$em->flush();
    return $this->render('PWProgresSiesBundle:ProgresSies:add.html.twig');
	}

	public function menuAction()
    {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $Series = array(
      array('id' => 2, 'title' => 'Walking Dead'),
      array('id' => 5, 'title' => 'Game of Thrones'),
      array('id' => 7, 'title' => 'Breaking Bad'),
      array('id' => 9, 'title' => 'House of cards')
    );

    return $this->render('PWProgresSiesBundle:ProgresSies:menu.html.twig', array('Series' => $Series) );
	}

}