<?php

namespace Raf\ChassorCoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message',     'textarea')
            ->add('date',        'datetime',     array('required' => false,
                                                   'widget' => 'single_text',
                                                   'format' => 'dd/MM/yyyy HH:mm',
                                                   'invalid_message' => 'Format attendu : "dd/mm/yyyy"'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raf\ChassorCoreBundle\Entity\Message'
        ));
    }

    public function getName()
    {
        return 'raf_chassorcorebundle_messagetype';
    }
}
