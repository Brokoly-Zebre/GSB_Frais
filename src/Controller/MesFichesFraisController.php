<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesFichesFraisController extends AbstractController
{
    #[Route('/mes/fiches/frais', name: 'app_mes_fiches_frais')]
    public function index(ManagerRegistry $doctrine): Response
    {
      $user = $this->getUser();

        $repository = $doctrine->getRepository(FicheFrais::class);
        $fichefrais = $repository->findAll();


        return $this->render('mes_fiches_frais/index.html.twig', [
            'controller_name' => 'MesFichesFraisController',
        ]);
    }
}
