<?php

namespace ST\AppBundle\Form\Type;

use  Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',                  TextType::class)
            ->add('ajouter un groupe',      SubmitType::class)
        ;
    }

    public function getName()
    {
        return "st_appbundle_category";
    }
}