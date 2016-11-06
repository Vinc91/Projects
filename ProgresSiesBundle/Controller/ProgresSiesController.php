<?php

namespace PW\ProgresSiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PW\ProgresSiesBundle\Entity\Serie;
use PW\ProgresSiesBundle\Entity\Saison;
use PW\ProgresSiesBundle\Entity\Image;
use PW\ProgresSiesBundle\Entity\Episode;
use PW\ProgresSiesBundle\Form\SerieType;
use PW\ProgresSiesBundle\Form\SerieEditType;
use PW\ProgresSiesBundle\Form\SaisonType;
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
      array('maj'=> 'desc'),
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
    		foreach($saison->getEpisodes() as $episode){
				$episode->setChecked(true);
				$em->persist($episode);
				$em->flush();
			}
			$serie->setMaj();
    		$em->persist($saison);
    		$em->persist($serie);
			$em->flush();
    		return $this->redirectToRoute('pw_progres_sies_view', array('id' => $serie->getId(),
				 'choice' => 0,
				 'saisonid'  => 0));
    	}
   		if($choice ==2){
    		$saison = $SaisonsRep->find($saisonid);
    		$saison->setChecked(false);
    		foreach($saison->getEpisodes() as $episode){
				$episode->setChecked(false);
				$em->persist($episode);
				$em->flush();
			}
			$serie->setMaj();
    		$em->persist($saison);
    		$em->persist($serie);
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


    public function viewsaisonAction($id, $choice, Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$SaisonsRep= $em->getRepository('PWProgresSiesBundle:Saison');
    	$saison = $SaisonsRep->find($id);
    	$serie = $saison->getSerie();
    	$episodes=$em->getRepository('PWProgresSiesBundle:Episode')->findBy(
    		array('saison' => $saison),
    		array('num' => 'asc'),
    		$saison->getNbEpisodes(),
    		0
    	);
    	$oldnbEpisodes = $saison->getNbEpisodes();
    	$form=$this->get('form.factory')->create(SaisonType::class,$saison);
    	if($choice ==1) {
    		$episode = new Episode();
    		$saison->addEpisode($episode);
    		$saison->setNbEpisodes($saison->getNbEpisodes()+1);
    		$num = $saison->searchNum($episodes);
    		$episode->setNum($num);
            $episode->setTitre($serie->getTitre().' - Saison '.$saison->getNum().' - Episode '.$episode->getNum());
            $saison->setAvancementTotal();
            $em->persist($saison);
            $em->persist($episode);
            $em->flush();
            return $this->redirectToRoute('pw_progres_sies_view_saison', array(
            	 'id' => $saison->getId(),
				 'choice' => 0));
    	}
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      		if($oldnbEpisodes <= $saison->getNbEpisodes()){
      			for($count=0; $count < $saison->getNbEpisodes() - $oldnbEpisodes;$count++) {
    				$Episodes=$em->getRepository('PWProgresSiesBundle:Episode')->findBy(
    					array('saison' => $saison),
    					array('num' => 'asc'),
    					$saison->getNbEpisodes(),
    					0
    				);
      				$episode = new Episode();
    				$saison->addEpisode($episode);
    				$num = $saison->searchNum($Episodes);
    				$episode->setNum($num);
            		$episode->setTitre($serie->getTitre().' - Saison '.$saison->getNum().' - Episode '.$episode->getNum());
            		$saison->setAvancementTotal();
            		$em->persist($episode);
            		$em->persist($saison);
            		$em->flush();
      			}
      		}else{
      		  if($oldnbEpisodes > $saison->getNbEpisodes()){
      		  	$newnbEpisodes = $saison->getNbEpisodes();
      			foreach($saison->getEpisodes() as $episode){
					$saison->removeEpisode($episode);
					$em->remove($episode);
					$em->flush();
				}
				for($count=0; $count < $newnbEpisodes; $count++){
					$Episodes=$em->getRepository('PWProgresSiesBundle:Episode')->findBy(
    					array('saison' => $saison),
    					array('num' => 'asc'),
    					$saison->getNbEpisodes(),
    					0
    				);
					$episode = new Episode();
    				$saison->addEpisode($episode);
    				$num = $saison->searchNum($Episodes);
    				$episode->setNum($num);
            		$episode->setTitre($serie->getTitre().' - Saison '.$saison->getNum().' - Episode '.$episode->getNum());
            		$saison->setAvancementTotal();
            		$em->persist($episode);
            		$em->persist($saison);
            		$em->flush();
				}
			  }
      		}
      		$saison->setAvancementTotal();
      		$serie->setAvancementTotal();
      		$serie->setMaj();
      		$em->persist($saison);
      		$em->persist($serie);
      		$em->flush();

      		return $this->redirectToRoute('pw_progres_sies_view_saison', array('id' => $id));
   		}

    	return $this->render('PWProgresSiesBundle:ProgresSies:viewsaison.html.twig', array(
    		'saison' => $saison,
    		'episodes' => $episodes,
    		'serie'  => $serie  ,
    		'form'	=> $form->createView() ));
    }


    public function viewallAction($page)
    {
    	$Series = $this->getDoctrine()
      		->getManager()
      		->getRepository('PWProgresSiesBundle:Serie')
      		->getSeries($page, 3);


    $nbPages = ceil(count($Series) / 3);
    return $this->render('PWProgresSiesBundle:ProgresSies:viewall.html.twig', array(
      'Series' => $Series,
      'nbPages'=> $nbPages,
      'page'   => $page,
    ));
    }

    public function addAction(Request $request)
    {
    	$serie = new Serie();
    
    	$form= $this->get('form.factory')->create(SerieType::class, $serie);
    	


    	if( $request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

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
    		$serie->setMaj();
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
    			foreach($saison->getEpisodes() as $episode){
					$saison->removeEpisode($episode);
					$em->remove($episode);
					$em->flush();
				}
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
      		$serie->setMaj();
      		$em->persist($serie);
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
			foreach($saison->getEpisodes() as $episode){
				$saison->removeEpisode($episode);
				$em->remove($episode);
				$em->flush();
			}
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
      array('maj'=> 'desc'),
      3, 
      0 
    );

    return $this->render('PWProgresSiesBundle:ProgresSies:menu.html.twig', array('Series' => $Series) );
	}
}