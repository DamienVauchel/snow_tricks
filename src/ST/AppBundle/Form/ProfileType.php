<?php

namespace ST\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',          ImageType::class, array('required' => false))
            ->add('firstname',      TextType::class)
            ->add('lastName',       TextType::class);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()

    {
        return 'app_user_profile';
    }

    public function getName()

    {
        return $this->getBlockPrefix();
    }

}