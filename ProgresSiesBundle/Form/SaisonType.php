<?php

namespace PW\ProgresSiesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PW\ProgresSiesBundle\Form\ImageType;
use PW\ProgresSiesBundle\Form\EpisodeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SaisonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('episodes',       CollectionType::class, array(
                    'entry_type'    =>  EpisodeType::class))
                ->add('nbEpisodes',  IntegerType::class)
                ->add('submit',         SubmitType::class, array('label'  =>  'Mettre à jour'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PW\ProgresSiesBundle\Entity\Saison'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pw_progressiesbundle_saison';
    }


}
