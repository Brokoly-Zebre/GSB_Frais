<?php

namespace App\Controller;

use App\Entity\FraisForfait;
use App\Form\FraisForfaisType;
use App\Repository\FraisForfaitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fraisforfais')]
class FraisForfaitController extends AbstractController
{
    #[Route('/', name: 'app_frais_forfais_index', methods: ['GET'])]
    public function index(FraisForfaitRepository $fraisForfaisRepository): Response
    {
        return $this->render('frais_forfais/index.html.twig', [
            'frais_forfais' => $fraisForfaisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_frais_forfais_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FraisForfaitRepository $fraisForfaisRepository): Response
    {
        $fraisForfai = new FraisForfait();
        $form = $this->createForm(FraisForfaisType::class, $fraisForfai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisForfaisRepository->add($fraisForfai, true);

            return $this->redirectToRoute('app_frais_forfais_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais_forfais/new.html.twig', [
            'frais_forfai' => $fraisForfai,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frais_forfais_show', methods: ['GET'])]
    public function show(FraisForfait $fraisForfai): Response
    {
        return $this->render('frais_forfais/show.html.twig', [
            'frais_forfai' => $fraisForfai,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_frais_forfais_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FraisForfait $fraisForfais, FraisForfaitRepository $fraisForfaisRepository): Response
    {
        $form = $this->createForm(FraisForfaisType::class, $fraisForfais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisForfaisRepository->add($fraisForfai, true);

            return $this->redirectToRoute('app_frais_forfais_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais_forfais/edit.html.twig', [
            'frais_forfais' => $fraisForfais,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frais_forfais_delete', methods: ['POST'])]
    public function delete(Request $request, FraisForfait $fraisForfai, FraisForfaitRepository $fraisForfaisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fraisForfai->getId(), $request->request->get('_token'))) {
            $fraisForfaisRepository->remove($fraisForfai, true);
        }

        return $this->redirectToRoute('app_frais_forfais_index', [], Response::HTTP_SEE_OTHER);
    }
}
