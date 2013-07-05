<?php

namespace Raf\ChassorAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GraphType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('xType',  'choice', array('choices' => array('enigme'    => 'Enigme',
                                                               'chassor'   => 'Chassor',
                                                               'date'      => 'Date')))
            ->add('yType',  'choice', array('choices' => array('tentative' => 'Tentatives',
                                                               'chassor'   => 'Chassors',
                                                               'indice'   => 'Indices',
                                                               'reponse'   => 'Reponses')))
            ->add('cumul',       'checkbox', array('required' => false))
            ->add('format',  'choice', array('choices' => array('line' => 'Line',
                                                               'bar'   => 'Bar')))
            ->add('date',        'date',     array('required' => false,
                                                   'widget' => 'single_text',
                                                   'format' => 'dd/MM/yyyy',
                                                   'invalid_message' => 'Format attendu : "dd/mm/yyyy"'))
            ->add('enigme',      'entity',   array('required' => false,
                                                   'empty_value' => '',
                                                   'class' => 'ChassorCoreBundle:Enigme',
                                                   'property' => 'codeInterne2',
                                                   'attr' => array('class' => 'myselect2')))
            ->add('chassor',      'entity',   array('required' => false,
                                                   'empty_value' => '',
                                                   'class' => 'ChassorCoreBundle:Chassor',
                                                   'property' => 'nomComplet',
                                                   'attr' => array('class' => 'myselect2')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raf\ChassorAdminBundle\Entity\Graph'
        ));
    }

    public function getName()
    {
        return 'raf_chassoradminbundle_graphtype';
    }
}
