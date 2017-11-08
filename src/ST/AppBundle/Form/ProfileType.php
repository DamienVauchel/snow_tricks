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
            ->add('firstname',      TextType::class, array('label' => "Prénom"))
            ->add('lastName',       TextType::class, array('label' => "Nom de Famille"))
            ->add('image',          ImageType::class, array(
                'required' => false,
                'label' => "Photo de profil"));
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