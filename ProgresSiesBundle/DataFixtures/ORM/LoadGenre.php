<?php

namespace PW\ProgresSiesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PW\ProgresSiesBundle\Entity\Genre;

class LoadGenre implements FixtureInterface {

	public function load(ObjectManager $manager) {

		$names = array(
				'Action',
				'Animation',
				'Arts Martiaux',
				'Aventure',
				'Comédie',
				'Drame',
				'Musicale',
				'Divers',
				'Epouvante horreur',
				'Espionnage',
				'Historique',
				'Politique',
				'Policier',
				'Sport',
				'Science fiction',
				'Western',
				'Médical',
				'Romance',
				'Fantastique'

		);

		foreach ($names as $name) {
			$genre = new Genre();
			$genre->setName($name);
			$manager->persist($genre);
		}

		$manager->flush();

	}

}