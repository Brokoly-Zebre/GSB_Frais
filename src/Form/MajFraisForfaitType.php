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
            ->add('Forfait_Etape', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ],

                'data'=>$currentfichefrais->getLigneFraisForfait()[0]->getQuantite(),

            ])
            ->add('Frais_Kilometrique', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ],
                'data'=>$currentfichefrais->getLigneFraisForfait()[1]->getQuantite(),
            ])
            ->add('Nuitee_Hotel', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ],
                'data'=>$currentfichefrais->getLigneFraisForfait()[2]->getQuantite(),
            ])
            ->add('Repas_Restaurant', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ],
                'data'=>$currentfichefrais->getLigneFraisForfait()[3]->getQuantite(),
            ])
            ->add('valide', SubmitType::class,[
                'label'=>'Valider',
                'attr'=>[
                    'class'=>'btn btn-primary'
                ],

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
