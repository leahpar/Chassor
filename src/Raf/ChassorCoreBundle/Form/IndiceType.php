<?php

namespace Raf\ChassorCoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enigme', 'entity',   array('empty_value' => '',
                                              'class' => 'ChassorCoreBundle:Enigme',
                                              'property' => 'codeInterne2',
                                              'attr' => array('class' => 'myselect2')))
            ->add('ordre',  'number')
            ->add('indice', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raf\ChassorCoreBundle\Entity\Indice'
        ));
    }

    public function getName()
    {
        return 'raf_chassorcorebundle_indicetype';
    }
}
