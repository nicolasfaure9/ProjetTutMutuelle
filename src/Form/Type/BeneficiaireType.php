<?php

namespace ProjetTutMutuelle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BeneficiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
           ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Les mots de passe doivent être identiques.',
                    'options' => array('required' => true),
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Repeter le mot de passe'),
                    
                ))
       //     ->add('save', 'submit', array(
         //       'label' => 'Mettre à jour',
            ;
    }

    public function getName()
    {
        return 'beneficiaire';
    }
}
