<?php

namespace PW\ProgresSiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PW\ProgresSiesBundle\Entity\Serie;
use PW\ProgresSiesBundle\Entity\Saison;
use PW\ProgresSiesBundle\Entity\Image;
use PW\ProgresSiesBundle\Form\SerieType;
use PW\ProgresSiesBundle\Form\SerieEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProgresSiesController extends Controller
{
    public function indexAction()
    {
        
    $em = $this->getDoctrine()->getManager();

    $Series = $em->getRepository('PWProgresSiesBundle:Serie')->findBy(
      array(),
      array(),
      3, 
      0 
    );
    return $this->render('PWProgresSiesBundle:ProgresSies:index.html.twig', array(
    	'Series'  => $Series));
    }

    public function viewAction($id, $choice, $saisonid)
    {
    	$em = $this->getDoctrine()->getManager();
    	$Series= $this->getDoctrine()->getManager()->getRepository('PWProgresSiesBundle:Serie');
    	$serie = $Series->find($id);
    	$SaisonsRep= $this->getDoctrine()->getManager()->getRepository('PWProgresSiesBundle:Saison');
    	$saisons=$em->getRepository('PWProgresSiesBundle:Saison')->findBy(
    		array('serie' => $serie),
    		array('num' => 'asc'),
    		$serie->getNbSaisons(),
    		0
    	);
    	if($choice == 1){
    		$saison = $SaisonsRep->find($saisonid);
    		$saison->setChecked(true);
    		$em->persist($saison);
			$em->flush();
    		return $this->redirectToRoute('pw_progres_sies_view', array('id' => $serie->getId(),
				 'choice' => 0,
				 'saisonid'  => 0));
    	}
   		if($choice ==2){
    		$saison = $SaisonsRep->find($saisonid);
    		$saison->setChecked(false);
    		$em->persist($saison);
			$em->flush();
    		return $this->redirectToRoute('pw_progres_sies_view', array('id' => $serie->getId(),
				 'choice' => 0,
				 'saisonid'  => 0));
   		}
    	$serie->setAvancementTotal();
    	$em->persist($serie);
    	$em->flush();
 
    return $this->render('PWProgresSiesBundle:ProgresSies:view.html.twig', array(
    	'serie'  => $serie,
    	'saisons' => $saisons));
    }

    public function viewallAction()
    {

    return $this->render('PWProgresSiesBundle:ProgresSies:viewall.html.twig');
    }

    public function addAction(Request $request)
    {
    	$serie = new Serie();
    
    	$form= $this->get('form.factory')->create(SerieType::class, $serie);
    	


    	if( $request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
    		if($serie->getImage() != null) {
    			$serie->getImage()->upload();
    		}
    		for($count=0; $count < $serie->getNbSaisons(); $count++) {
            	$saison = new Saison();
            	$serie->addSaison($saison);
            	$saison->setSerie($serie);
            	$saison->setNum($count+1);
            	$saison->setTitre($serie->getTitre().' - Saison '.$saison->getNum());
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

	public function updateAction($id, $choice, $saisonid,Request $request) {
			$em =$this->getDoctrine()->getManager();
			$serie = $em->getRepository('PWProgresSiesBundle:Serie')->find($id);
			$saisons=$em->getRepository('PWProgresSiesBundle:Saison')->findBy(
    			array('serie' => $serie),
    			array('num' => 'asc'),
    			$serie->getNbSaisons(),
    			0
    		);
			$form=$this->get('form.factory')->create(SerieEditType::class,$serie);

			if($choice == 1){
   			$SaisonsRep= $this->getDoctrine()->getManager()->getRepository('PWProgresSiesBundle:Saison');
    		$saison = $SaisonsRep->find($saisonid);
				$serie->removeSaison($saison);
				$serie->setNbSaisons($serie->getNbSaisons()-1);
				$em->remove($saison);
				$em->flush();
				return $this->redirectToRoute('pw_progres_sies_update', array(	 'id' => $serie->getId(),
							'choice' => 0,
							'saisonid'  => 0));
			}

			if($choice == 2){
				$saison = new Saison();
				$saison->setNum($serie->searchNum($saisons));
				$saison->setTitre($serie->getTitre().' - Saison '.$saison->getNum());
				$serie->addSaison($saison);
				$serie->setNbSaisons($serie->getNbSaisons()+1);
				$em->persist($saison);
				$em->flush();
				return $this->redirectToRoute('pw_progres_sies_update', array(
							'id' => $serie->getId(),
							'choice' => 0,
							'saisonid'  => 0));

			}


		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      		
      		$em->flush();

      		return $this->redirectToRoute('pw_progres_sies_view', array('id' => $serie->getId()));
   		}

	return $this->render('PWProgresSiesBundle:ProgresSies:update.html.twig', array(
		'serie' => $serie,
		'saisons' =>$saisons,
		'form'  => $form->createView()
	));
	}


	public function deleteAction($id) {
		$em = $this->getDoctrine()->getManager();
		$serie = $em->getRepository('PWProgresSiesBundle:Serie')->find($id);
		$saisons = $em->getRepository('PWProgresSiesBundle:Saison')->findBySerie($serie);

		foreach($saisons as $saison ) {
			$em->remove($saison);
			$em->flush();
		}

		$em->remove($serie);
		$em->flush();
		return $this->redirectToRoute('pw_progres_sies_home');

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