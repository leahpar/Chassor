<?php

namespace Raf\ChassorCoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sujet',     'text')
            ->add('template',  'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raf\ChassorCoreBundle\Entity\Mail'
        ));
    }

    public function getName()
    {
        return 'raf_chassorcorebundle_mailtype';
    }
}
