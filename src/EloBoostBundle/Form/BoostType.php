<?php

namespace EloBoostBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fromLP', ChoiceType::class, array(
            'choices'  => array(
                '0-20 LP' => '0-20 LP',
                '20-40 LP' => '20-40 LP',
                '40-60 LP' => '40-60 LP',
                '60-80 LP' => '60-80 LP',
                '80-100 LP' => '80-100 LP',
            )))->add('fromDiv', ChoiceType::class, array(
            'choices'  => array(
                'Division V' => 'Division V',
                'Division IV' => 'Division VI',
                'Division III' => 'Division III',
                'Division II' => 'Division II',
                'Division I' => 'Division I',
            )))->add('fromLG', ChoiceType::class, array(
            'choices'  => array(
                'Bronze' => 'Bronze',
                'Silver' => 'Silver',
                'Gold' => 'Gold',
            )))->add('toDiv', ChoiceType::class, array(
            'choices'  => array(
                'Division V' => 'Division V',
                'Division IV' => 'Division VI',
                'Division III' => 'Division III',
                'Division II' => 'Division II',
                'Division I' => 'Division I',
            )))
            ->add('toLG', ChoiceType::class, array(
            'choices'  => array(
                'Bronze' => 'Bronze',
                'Silver' => 'Silver',
                'Gold' => 'Gold',
            )))
            ->add('Add',SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EloBoostBundle\Entity\Boost'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eloboostbundle_boost';
    }


}
