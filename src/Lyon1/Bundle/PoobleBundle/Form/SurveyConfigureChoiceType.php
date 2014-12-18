<?php

namespace Lyon1\Bundle\PoobleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SurveyConfigureChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
           ->add('choice', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*
        $resolver->setDefaults(array(
            'data_class' => 'Lyon1\Bundle\PoobleBundle\Entity\Survey'
        ));
        */
    }

    public function getName()
    {
        return 'configure_choice';
    }
}
