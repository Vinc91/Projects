<?php

namespace PW\ProgresSiesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use PW\ProgresSiesBundle\Form\SaisonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SerieEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('nbSaisons')
        		->remove('submit')
        		->add('submit', SubmitType::class, array('label'  =>  'Mettre à jour'));
    }
    
    public function getParent() {

        return SerieType::class;

    }


}
