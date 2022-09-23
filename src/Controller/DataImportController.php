<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class DataImportController extends AbstractController
{
    #[Route('/dataimport', name: 'app_data_import')]
    public function index(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $file = file_get_contents("visiteur.json");
        $userjson = json_decode($file);
        var_dump($userjson);

        foreach ($userjson as $user) {
            $newUser = new User();
            $newUser->setOldId($user->id);
            $newUser->setLogin($user->login);
            $newUser->setNom($user->nom);
            $newUser->setPrenom($user->prenom);
            $newUser->setCp($user->cp);
            $newUser->setVille($user->ville);
            $newUser->setAdresse($user->adresse);
            $newUser->setDateEmbauche(new \DateTime($user->dateEmbauche));

            $plaintextpassword = $user->mdp;
            $hashedpassword = $passwordHasher->hashPassword($newUser, $plaintextpassword);

            $newUser->setPassword($hashedpassword);
            $doctrine->getManager()->persist($newUser);
            $doctrine->getManager()->flush();


        }
        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }


    #[Route('/importfiche', name: 'app_data_importfiche')]
    public function indexFiche(ManagerRegistry $doctrine,): Response
    {
        $fichefraisjson = file_get_contents("FicheFrais.json");
        $fichesfrais= json_decode($fichefraisjson);
        var_dump($fichesfrais);

        foreach ($fichefraisjson as $fichefrais) {


            $newFichefrais = new FicheFrais();
            $newFichefrais->setMois($fichefrais->mois);
            $newFichefrais->setMontantValide($fichefrais->montantValide);
            $newFichefrais->setNbJustificatifs($fichefrais->nbJustificatifs);
            $newFichefrais->setDateModif(new \DateTime($fichefrais->dateModif));
            $user = $doctrine->getRepository(User::class)->findOneBy(['oldId'=>$fichefrais->idvisiteur]);
            $newFichefrais->setUser($user);
            $newFichefrais->setEtat($fichefrais->idEtat);

            $doctrine->getManager()->persist($newFichefrais);
            $doctrine->getManager()->flush();

        }
        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }
}




