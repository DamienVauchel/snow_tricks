<?php

namespace ST\AppBundle\Form;

use  Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message',                TextareaType::class)
            ->add('envoyer le commentaire',     SubmitType::class)
        ;
    }

    public function getName()
    {
        return "st_appbundle_comment";
    }
}