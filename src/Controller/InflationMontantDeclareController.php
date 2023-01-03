<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Entity\User;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InflationMontantDeclareController extends AbstractController
{
    #[Route('/inflation/montant/declare', name: 'app_inflation_montant_declare')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $fichefraisjson = file_get_contents("FicheFrais.json");
        $fichefrais = json_decode($fichefraisjson);

        foreach ($fichefrais as $fiche_frais)
            $fichefrais = $doctrine->getRepository(FicheFrais::class)->findAll($fichefrais);
        $user = $doctrine->getRepository(User::class)->findAll($user);




        



        return $this->render('inflation_montant_declare/index.html.twig', [
            'controller_name' => 'InflationMontantDeclareController',


        ]);
    }
}
