<?php

namespace App\Controller;

use App\Entity\FicheFrais;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisieFicheFraisController extends AbstractController
{
    #[Route('/saisie/fiche/frais', name: 'app_saisie_fiche_frais')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $repository = $doctrine->getRepository(FicheFrais::class);
        $mois = $repository->findBy(['user'=>$user, 'mois']);
        $mois = [];





        return $this->render('saisie_fiche_frais/index.html.twig', [
            'controller_name' => 'SaisieFicheFraisController',
        ]);
    }
}
