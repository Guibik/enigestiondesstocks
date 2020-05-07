<?php

namespace App\Controller;

use App\Entity\Ouvrage;
use App\Form\OuvrageFormType;
use App\Form\OuvrageStockType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\UniqueValidator;

class OuvrageController extends AbstractController
{
    /**
     * @Route("/ouvrage", name="ouvrage")
     */
    public function index()
    {
        return $this->render('ouvrage/index.html.twig', [
            'controller_name' => 'OuvrageController',
            'current_menu' => 'ourages',
            'form_title' => 'Liste des ouvrages',
        ]);
    }

    /**
     * @Route("/formator/addOuvrage", name="addOuvrage")
     */
    public function addOuvrage(Request $request, EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
//        Création d'un objet
        $ouvrage = new Ouvrage();
//        Création du formulaire
        $form = $this->createForm(OuvrageFormType::class, $ouvrage);
//        Récupération des requêtes avec le handleRequest
        $form->handleRequest($request);
//        Vérification que les valeurs entréess sont corrects
        if ($form->isSubmitted() && $form->isValid()) {
//            if ($ouvrage->getTitre() === UniqueEntity::CLASS_CONSTRAINT && $ouvrage->getSite() === UniqueEntity::CLASS_CONSTRAINT) {
//                $this->addFlash("alert", "Création non valide car cet ouvrage est déjà existant sur ce site !");
//                return $this->render('ouvrage/ajouter.html.twig', [
//                    'form_title' => 'Etat stock',
//                    'form' => $form->createView(),
//                    'ouvrage' => $ouvrage]);
//            }
//        Les informations sont envoyées en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($ouvrage);
            $em->flush();

            $this->addFlash("success", "Création réussie !");
            return $this->redirectToRoute('ouvrages');
        }
//        Les informations sont retournées à la vue
        return $this->render('ouvrage/ajouter.html.twig', [
            'form_title' => 'Créer un nouvel ouvrage',
            'ouvrageForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ouvrages", name="ouvrages")
     */
    public function ouvrages()
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $ouvrages = $this->getDoctrine()->getRepository(Ouvrage::class)->findAll();

        return $this->render('ouvrage/detail.html.twig', [
            'form_title' => 'Liste des ouvrages',
           'ouvrages' => $ouvrages
        ]);
    }

    /**
     * @Route("/formator/updateOuvrage/{id}", name="updateOuvrage")
     */
    public  function updateOuvrage(Request $request, int $id, EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();
        $ouvrage = $em->getRepository(Ouvrage::class)->find($id);
        $form = $this->createForm(OuvrageFormType::class, $ouvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            $this->addFlash("success", "modification effectuée");
            return $this->redirectToRoute('ouvrage_search');
        }

        return $this->render('ouvrage/modifier.html.twig', [
            'form_title' => 'Modifier un ouvrage',
            'ouvrageForm' => $form->createView()
            ]);
    }

    /**
     * @Route("/admin/deleteOuvrage/{id}", name="deleteOuvrage")
     */
    public function deleteOuvrage(int $id, EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();
        $ouvrage = $em->getRepository(Ouvrage::class)->find($id);
        $em->remove($ouvrage);
        $em->flush();

        return $this->redirectToRoute('ouvrages');
    }

    /**
     * @Route("/formator/addEtatStock{id}", name="addEtatStock")
     */
    public function addStock (EntityManagerInterface $em, Request $request,int $id)
    {
        //Récupère l'ouvrage celon son id
        $ouvrage = $em->getRepository(Ouvrage::class)->find($id);

        //Récupère la quantite existante de la classe ouvrage
        $quantiteStock = $ouvrage->getQuantiteStock();

        //Création du formulaire
        $form = $this->createForm(OuvrageStockType::class, $ouvrage);
        $form->handleRequest($request);

        //Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            //Récupère le choix (entrée ou/et sortie) et la quantité
            $quantiteEntree = $form->get('quantiteEntree')->getViewData();
            $quantiteSortie = $form->get('quantiteSortie')->getViewData();

            //Si entrée
            if ($quantiteEntree != null) {
                $ouvrage->setQuantiteStock($ouvrage->getQuantiteStock() + $quantiteEntree);
                //Sinon sortie
            }
            if ($quantiteSortie != null) {
                $ouvrage->setQuantiteStock($ouvrage->getQuantiteStock() - $quantiteSortie);
                //Si quantité inférieur à 0, alors erreur
                if ($ouvrage->getQuantiteStock() < 0) {
                    $this->addFlash("warning", "Le stock ne peut pas être négatif !");

                    return $this->render('etat_stock/ajouter.html.twig', [
                        'form_title' => 'Etat stock',
                        'form' => $form->createView(),
                        'ouvrage' => $ouvrage,
                    ]);

                    //Sinon c'est good
                }
//                else {
//                    $ouvrage->setStockTotal($stockTotal);
//                }
            }
            //Envoi des informations saisie à la BDD
            $em->persist($ouvrage);
            $em->flush();
            $this->addFlash("success", "La quantité a été modifié avec succès !");
            return $this->redirectToRoute('ouvrage_search', array('id' => $ouvrage->getId()));
        }
        return $this->render('etat_stock/ajouter.html.twig', [
            'form_title' => 'Etat stock',
            'form' => $form->createView(),
            'ouvrage' => $ouvrage,
        ]);
    }


}
