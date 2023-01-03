<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Entity\User;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InflationMontantValideController extends AbstractController
{
    #[Route('/inflation/montant/valide', name: 'app_inflation_montant_valide')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $fichefraisjson = file_get_contents("FicheFrais.json");
        $fichefrais = json_decode($fichefraisjson);

        foreach ($fichefrais as $fiche_frais)
        $fichefrais = $doctrine->getRepository(FicheFrais::class)->findAll($fichefrais);
        $user = $doctrine->getRepository(User::class)->findAll($user);
        $newfichefrais->set



        return $this->render('inflation_montant_valide/index.html.twig', [
            'controller_name' => 'InflationMontantValideController',
        ]);

    }
}
