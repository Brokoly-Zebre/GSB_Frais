<?php

namespace App\Form;

use App\Entity\LigneFraisHorsForfait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaisieFraisHorsForfaitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class)
            ->add('libelle',TextType::class)
            ->add('montant', NumberType::class, [
                'attr' => [
                    'min' => 0,
                ]
            ])
        ->add('valide', SubmitType::class,[
            'label'=>'Valider',
            'attr'=>[
                'class'=>'btn btn-primary'
            ]

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneFraisHorsForfait::class,
        ]);
    }
}
