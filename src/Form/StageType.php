<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('email')
            ->add('entreprise', EntrepriseType::class, ['label' =>'l\'entreprise du stage'])
            ->add('formations', EntityType::class, ['class'=>Formation::class, // 'App\Entity\Formation'
                                                    'choice_label'=>'nomLong',
                                                    'expanded'=>true,
                                                    'multiple'=>true,
                                                    'label' => 'le stage est proposé aux formations suivantes:'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
