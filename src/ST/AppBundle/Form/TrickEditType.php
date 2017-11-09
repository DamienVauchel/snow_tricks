<?php

namespace ST\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TrickEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('ajouter la figure')
            ->remove('image')
            ->add('image',                  ImageType::class,       array('required' => false))
            ->add('modifier la figure',      SubmitType::class);
    }

    public function getParent()
    {
        return TrickType::class;
    }
}