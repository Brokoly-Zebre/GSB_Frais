<?php

namespace App\Controller;

use App\Entity\FicheFrais;

use App\Form\MesFichesFraisType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesFichesFraisController extends AbstractController
{
    #[Route('/mes_fiches_frais', name: 'app_mes_fiches_frais')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
      $user = $this->getUser();

        $repository = $doctrine->getRepository(FicheFrais::class);
        $fichesfrais = $repository->findBy(['user'=>$user]);
        $mois = [];
       foreach ($fichesfrais as $fichefrais ) {
           $mois[$fichefrais->getMois()] = $fichefrais->getMois();
       }

        $myForm = $this->createForm(MesFichesFraisType::class, null, ['liste_mois'=>$mois]);
        $myForm->handleRequest($request);
        if ($myForm->isSubmitted() && $myForm->isValid()){
            $selectedMois = $myForm->getData();

            $fichefrais = $repository->findOneBy(['user'=>$user,'mois'=>$selectedMois]);
            $myFormData = $myForm->getData();
            $mois = $myFormData['liste_mois'];


        }

        return $this->render('mes_fiches_frais/index.html.twig', [
            'controller_name' => 'MesFichesFraisController',
            'myForm'=> $myForm,
            'fiche_frais'=>$fichefrais

        ]);
    }
}