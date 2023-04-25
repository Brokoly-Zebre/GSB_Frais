<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\FicheFrais;

use App\Entity\FraisForfait;
use App\Entity\LigneFraisForfait;
use App\Entity\LigneFraisHorsForfait;
use App\Form\MajFraisForfaitType;
use App\Form\MesFichesFraisType;
use App\Form\SaisieFraisHorsForfaitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisieFicheFraisController extends AbstractController
{
    #[Route('/saisiefichefrais', name: 'app_saisie_fiche_frais')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $date = new \DateTime();
        $moisEnCours = $date->format('Ym');

        $repository = $doctrine->getRepository(FicheFrais::class);
        $ficheFrais = $repository->findOneBy(['user' => $user, 'mois' => $moisEnCours]);

        $entityManager = $doctrine->getManager();

        if ($ficheFrais == null) {

            $ficheFrais = new FicheFrais();
            $ficheFrais->setUser($user);
            $ficheFrais->setMois($moisEnCours);
            $ficheFrais->setDateModif(new \DateTime('now'));
            $ficheFrais->setNbjustificatifs('0');
            $ficheFrais->setMontantValid('0');

            //ajout de la lff nuité
            $lffNuite = new LigneFraisForfait();
            $lffNuite->setQuantite(0);
            $lffNuite->setFicheFrais($ficheFrais);
            $lffNuite->setFraisForfait($doctrine->getRepository(FraisForfait::class)->find(3));
            $ficheFrais->addLigneFraisForfait($lffNuite);


            //ajout de la lff Forfait Etape
            $lffForfaitEtape = new LigneFraisForfait();
            $lffForfaitEtape->setQuantite(0);
            $lffForfaitEtape->setFicheFrais($ficheFrais);
            $lffForfaitEtape->setFraisForfait($doctrine->getRepository(FraisForfait::class)->find(1));
            $ficheFrais->addLigneFraisForfait($lffForfaitEtape);

            //AJOUT DE LA LFF FRAIS KILOMETRIQUE

            $lffFraisKilometrique = new LigneFraisForfait();
            $lffFraisKilometrique->setQuantite(0);
            $lffFraisKilometrique->setFicheFrais($ficheFrais);
            $lffFraisKilometrique->setFraisForfait($doctrine->getRepository(FraisForfait::class)->find(2));
            $ficheFrais->addLigneFraisForfait($lffFraisKilometrique);


            // AJOUT DE LA LFF REPAS RESTAURANT

            $lffRepas = new LigneFraisForfait();
            $lffRepas->setQuantite(0);
            $lffRepas->setFicheFrais($ficheFrais);
            $lffRepas->setFraisForfait($doctrine->getRepository(FraisForfait::class)->find(4));
            $ficheFrais->addLigneFraisForfait($lffRepas);


            $repository = $doctrine->getRepository(Etat::class);
            $etat = $repository->find(2);
            $ficheFrais->setEtat($etat);



            $entityManager->persist($ficheFrais);
            $entityManager->flush();
        }

        $myForm = $this->createForm(MajFraisForfaitType::class, null,['current_fiche_frais'=> $ficheFrais]);
        $myForm->handleRequest($request);

        //dd($ficheFrais);

        if ($myForm->isSubmitted() && $myForm->isValid()) {
            $quantite = $myForm->getData();

            //dd($quantite);

            $ficheFrais->getLigneFraisForfait()[0]->setQuantite($quantite['lff_forfait_etape']);
            $ficheFrais->getLigneFraisForfait()[1]->setQuantite($quantite['lff_frais_kilometrique']);
            $ficheFrais->getLigneFraisForfait()[2]->setQuantite($quantite['lff_nuitee_hotel']);
            $ficheFrais->getLigneFraisForfait()[3]->setQuantite($quantite['lff_repas_restaurant']);

            $entityManager->persist($ficheFrais);
            $entityManager->flush();
        }

        $lfhf = new LigneFraisHorsForfait();
        $formlfhf = $this->createForm(SaisieFraisHorsForfaitType::class, $lfhf);
        $formlfhf ->handleRequest($request);
        if ($formlfhf ->isSubmitted() && $formlfhf ->isValid()){
                $ficheFrais->addLigneHorsForfait($lfhf);
            $entityManager->persist($ficheFrais);
            $entityManager->flush();



        }

            return $this->render('saisie_fiche_frais/index.html.twig', [
                'controller_name' => 'SaisieFicheFraisController',
                'myForm' => $myForm,
                'formlfhf'=> $formlfhf,
                'fiche_frais'=>$ficheFrais

            ]);
        }

}
