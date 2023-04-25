<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MajFraisForfaitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentfichefrais = $options['current_fiche_frais'];

        $builder
            ->add('lff_forfait_etape', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ],
                'data'=>$currentfichefrais->getLigneFraisForfait()[0]->getQuantite(),
            ])
            ->add('lff_frais_kilometrique', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('lff_nuitee_hotel', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('lff_repas_restaurant', IntegerType::class, [
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
            // Configure your form options here
            'current_fiche_frais'=> null,
        ]);
    }
}
