<?php

namespace Raf\ChassorUserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('nom',     'text')
                ->add('prenom',  'text')
                ->add('adresse', 'textarea')
        ;
    }

    public function getName()
    {
        return 'chassor_user_registration';
    }
}