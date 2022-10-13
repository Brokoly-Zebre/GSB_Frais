<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\FicheFrais;
use App\Entity\FraisForfait;
use App\Entity\LigneFraisForfait;
use App\Entity\LigneFraisHorsForfait;
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
    public function importFiche(ManagerRegistry $doctrine,): Response
    {
        $fichefraisjson = file_get_contents("FicheFrais.json");
        $fichesfrais = json_decode($fichefraisjson);


        foreach ($fichesfrais as $fichefrais) {


            $newFichefrais = new FicheFrais();
            $newFichefrais->setMois($fichefrais->mois);
            $newFichefrais->setMontantValid($fichefrais->montantValide);
            $newFichefrais->setNbJustificatifs($fichefrais->nbJustificatifs);
            $newFichefrais->setDateModif(new \DateTime($fichefrais->dateModif));
            $user = $doctrine->getRepository(User::class)->findOneBy(['oLdId' => $fichefrais->idVisiteur]);
            $newFichefrais->setUser($user);


            switch ($fichefrais->idEtat) {
                case "VA":
                    $etat = $doctrine->getRepository(Etat::class)->find(4);
                    break;

                case "CR":
                    $etat = $doctrine->getRepository(Etat::class)->find(2);
                    break;

                case "CL":
                    $etat = $doctrine->getRepository(Etat::class)->find(1);
                    break;
                case "RB":

                    $etat = $doctrine->getRepository(Etat::class)->find(3);
                    break;

            }

            $newFichefrais->setEtat($etat);

            $doctrine->getManager()->persist($newFichefrais);
            $doctrine->getManager()->flush();
        }
        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }

    #[Route('/lignefraisforfaitimport', name: 'app_data_import_lff')]
    public function ImportLigneFraisForfait(ManagerRegistry $doctrine): Response
    {
        $ligne_frais_forfaitjson = file_get_contents("ligne_frais_forfait.json");
        $ligne_frais_forfait = json_decode($ligne_frais_forfaitjson);

        foreach ($ligne_frais_forfait as $lignefraisforfait) {
            $newligneFraisForfait = new LigneFraisForfait();
            $user = $doctrine->getRepository(User::class)->findOneBy(['oldId' => $lignefraisforfait->idVisiteur]);
            $ficheFrais = $doctrine->getRepository(FicheFrais::class)->findOneBy(['user'=> $user,'mois'=>$lignefraisforfait->mois]);
            $newligneFraisForfait->setFicheFrais($ficheFrais);
            $newligneFraisForfait->setQuantite($lignefraisforfait->quantite);

            switch ($lignefraisforfait->idFraisForfait) {
                case "ETP":
                    $fraisforfait= $doctrine->getRepository(FraisForfait::class)->find(1);
                    break;

                case "KM":
                    $fraisforfait = $doctrine->getRepository(FraisForfait::class)->find(2);
                    break;

                case "NUI":
                    $fraisforfait = $doctrine->getRepository(FraisForfait::class)->find(3);
                    break;

                case "REP":
                    $fraisforfait = $doctrine->getRepository(FraisForfait::class)->find(4);
                    break;
            }
            $newligneFraisForfait->setFraisForfait($fraisforfait);

            $doctrine->getManager()->persist($newligneFraisForfait);
            $doctrine->getManager()->flush();


        }
        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }


    #[Route('/lignefraishorsforfaitimport', name: 'app_data_import_lfhf')]
    public function ImportLigneFraisHorsForfait(ManagerRegistry $doctrine): Response
    {
        $ligne_frais_hors_forfaitjson = file_get_contents("ligne_frais_hors_forfait.json");
        $ligne_frais_hors_forfait = json_decode($ligne_frais_hors_forfaitjson);

        foreach ($ligne_frais_hors_forfait as $lignefraishorsforfait) {

            $newligneFraisHorsForfait = new LigneFraisHorsForfait();
            $user = $doctrine->getRepository(User::class)->findOneBy(['oldId' => $lignefraishorsforfait->idVisiteur]);
            $ficheFrais = $doctrine->getRepository(FicheFrais::class)->findOneBy(['user'=> $user,'mois'=>$lignefraishorsforfait->mois]);
            $newligneFraisHorsForfait->setFicheFrais($ficheFrais);
            $newligneFraisHorsForfait->setDate($lignefraishorsforfait->date);
            $newligneFraisHorsForfait->setLibelle($lignefraishorsforfait->libelle);
            $newligneFraisHorsForfait->setMontant($lignefraishorsforfait->montant);

            //$doctrine->getManager()->persist($newligneHorsFraisForfait);
            //$doctrine->getManager()->flush();

        }
        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
        ]);
    }

}


