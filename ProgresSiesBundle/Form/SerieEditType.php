<?php

namespace PW\ProgresSiesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SerieEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('nbSaisons');
    }
    
    public function getParent() {

        return SerieType::class;

    }


}
