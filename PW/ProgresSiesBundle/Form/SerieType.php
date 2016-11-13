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

class SerieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre',      TextType::class, array('label'  =>  'Titre de la série'))
                ->add('date',       IntegerType::class)
                ->add('createur',   TextType::class, array('label'  =>  'Créateur'))
                ->add('nbSaisons',  IntegerType::class)
                ->add('image',      ImageType::class)
                ->add('genres',      EntityType::class, array(
                    'class'        => 'PWProgresSiesBundle:Genre',
                    'choice_label' => 'name',
                    'multiple'     => true,
                    'expanded'     => true))
                ->add('submit', SubmitType::class, array('label'  =>  'Ajouter'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PW\ProgresSiesBundle\Entity\Serie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pw_progressiesbundle_serie';
    }


}
