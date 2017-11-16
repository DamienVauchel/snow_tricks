<?php

namespace ST\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TrickEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('ajouter la figure')
            ->remove('images')
            ->add('images',         CollectionType::class, array(
                'entry_type'        => ImageType::class,
                'allow_add'         => true,
                'by_reference'      => false,
                'required' => false
            ))
            ->add('modifier la figure',      SubmitType::class);
    }

    public function getParent()
    {
        return TrickType::class;
    }
}