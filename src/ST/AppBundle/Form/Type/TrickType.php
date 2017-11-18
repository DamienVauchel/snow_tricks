<?php

namespace ST\AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use  Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',                  TextType::class)
            ->add('images',         CollectionType::class,array(
                'entry_type'        => ImageType::class,
                'allow_add'         => true,
                'by_reference'      => false
            ))
            ->add('description',            TextareaType::class)
            ->add('level',                  ChoiceType::class,  array(
                'choices' => array(
                    'Facile' => 'easy',
                    'Moyen' => 'medium',
                    'Difficile' => 'hard'
                )
            ))
            ->add('category',                  EntityType::class,  array(
                'class' => 'ST\AppBundle\Entity\Category',
                'choice_label' => 'name'
            ))
            ->add('ajouter la figure',      SubmitType::class)
        ;
    }

    public function getName()
    {
        return "st_appbundle_trick";
    }
}
