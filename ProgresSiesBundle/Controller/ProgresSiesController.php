<?php

namespace PW\ProgresSiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PW\ProgresSiesBundle\Entity\Serie;
use PW\ProgresSiesBundle\Entity\Saison;
use PW\ProgresSiesBundle\Entity\Image;
use PW\ProgresSiesBundle\Form\SerieType;
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
    	/*
    	$serie->setTitre("Walking Dead");
    	$serie->setCreateur("MArivin gay");
    	$serie->setNbSaisons(7);
    	*/
    	$form= $this->get('form.factory')->create(SerieType::class, $serie);
    	/*
    	$image= new Image();
    	$image->setUrl('http://fr.web.img5.acsta.net/medias/nmedia/18/78/35/82/20303823.jpg');
    	$image->setAlt('Walking Dead');
		
    	$serie->setImage($image);
    	*/
    	if( $request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
    		if($serie->getImage() != null) {
    			$serie->getImage()->upload();
    		}
    		for($count=0; $count < $serie->getNbSaisons(); $count++) {
            	$saison = new Saison();
            	$saison->setSerie($serie);
            	$name = $count+1;
            	$saison->setTitre($serie->getTitre().' - Saison '.$name);
            	$em = $this->getDoctrine()->getManager();
            	$em->persist($saison);
            	$em->flush();
        	}
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($serie);
    		$em->flush();
    		return $this->redirectToRoute('pw_progres_sies_view', array('id'=> $serie->getId()));
    	}
   		 return $this->render('PWProgresSiesBundle:ProgresSies:add.html.twig', array('form' => $form->createView()));
	}

	public function updateAction($id, Request $request) {
			return $this->render('PWProgresSiesBundle:update.html.twig');
	}

	public function menuAction()
    {
    
    $em = $this->getDoctrine()->getManager();

    $Series = $em->getRepository('PWProgresSiesBundle:Serie')->findBy(
      array(),
      array(),
      3, 
      0 
    );

    return $this->render('PWProgresSiesBundle:ProgresSies:menu.html.twig', array('Series' => $Series) );
	}

}