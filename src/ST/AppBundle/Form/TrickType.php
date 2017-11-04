<?php

namespace ST\AppBundle\Form;

use  Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            ->add('description',            TextareaType::class)
            ->add('level',                  ChoiceType::class,  array(
                'choices' => array(
                    'Facile' => 'easy',
                    'Moyen' => 'medium',
                    'Difficile' => 'hard'
                )
            ))
            ->add('slug',                   TextType::class)
            ->add('ajouter la figure',      SubmitType::class)
        ;
    }

    public function getName()
    {
        return "st_appbundle_trick";
    }
}