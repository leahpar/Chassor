<?php

namespace Raf\ChassorCoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EnigmeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',        'text')
            ->add('titre',       'text')
            ->add('commentaire', 'textarea', array('required' => false))
            ->add('reponses',    'text',     array('required' => false))
            ->add('date',        'date',     array('required' => false,
                                                   'widget' => 'single_text',
                                                   'format' => 'dd/MM/yyyy',
                                                   'invalid_message' => 'Format attendu : "dd/mm/yyyy"'))
            ->add('delai',       'integer',  array('required' => false))
            ->add('depend',      'entity',   array('required' => false,
                                                   'empty_value' => '',
                                                   'class' => 'ChassorCoreBundle:Enigme',
                                                   'property' => 'code',
                                                   'attr' => array('class' => 'myselect2')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raf\ChassorCoreBundle\Entity\Enigme'
        ));
    }

    public function getName()
    {
        return 'raf_chassorcorebundle_enigmetype';
    }
}
