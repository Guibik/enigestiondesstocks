<?php

namespace App\Controller;

use App\Entity\EtatStock;
use App\Entity\Ouvrage;
use App\Form\EtatStockType;
use App\Form\OuvrageFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EtatStockController extends AbstractController
{
    /**
     * @Route("/etat/stock", name="etat_stock")
     */
    public function index()
    {
        return $this->render('etat_stock/index.html.twig', [
            'controller_name' => 'EtatStockController',
        ]);
    }

//    /**
//     * @Route("/addEtatStock{id}", name="addEtatStock")
//     */
//    public function addEtatStock(EntityManagerInterface $em, Request $request, int $id)
//    {
//        if (!$this->getUser()) {
//            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
//            return $this->redirectToRoute('home');
//        }
//        $etatStock = new EtatStock();
//        //Récupérer l'étatStock selon son id
//        $etatStock = $em->getRepository(EtatStock::class)->find($id);
//
//        //Récupération de la quantité existante
//        $stockTotal = $etatStock->getStockTotal();
//
//        //Création du formulaire
//        $etatStockForm = $this->createForm(EtatStockType::class, $etatStock);
//        $etatStockForm->handleRequest($request);
//
//        if ($etatStockForm->isSubmitted() && $etatStockForm->isValid()) {
//            if ($etatStock->getQuantiteEntree() != null) {
//                $etatStock->setStockTotal($etatStock->getStockTotal() + $etatStock->getQuantiteEntree());
//            }
//            if ($etatStock->getQuantiteSortie() != null) {
//                $etatStock->setStockTotal($etatStock->getStockTotal() - $etatStock->getQuantiteSortie());
//                if ($stockTotal < 0) {
//                    $this->addFlash("succes", "Le stock ne peut pas être négatif !");
//
//                    return $this->render('etat_stock/ajouter.html.twig', [
//                        'etatStockForm' => $etatStockForm->createView(),
//                        'etatStock' => $etatStock,
//                    ]);
//
//                    //Sinon c'est good
//                } else {
//                    $etatStock->setStockTotal($stockTotal);
//                }
//            }
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($etatStock);
//            $em->flush();
//            $this->addFlash("success", "Le nouveau stock a bien été modifié");
//            return $this->redirectToRoute('ouvrage_search', array('id' => $etatStock->getId()));
//        }
//
//        return $this->render('etat_stock/ajouter.html.twig', [
//            'form_title' => 'Etat stock',
//            'form' => $etatStockForm->createView(),
//            'etatStock' => $etatStock,
////            'etatStocks' => $etatStocks,
//        ]);
//    }

//    /**
//     * @Route("/addEtatStock{id}", name="addEtatStock")
//     */
//    public function addStock (EntityManagerInterface $em, Request $request,int $id)
//    {
////        $em = $this->getDoctrine()->getManager();
//        //Récupère l'ouvrage celon son id
//        $ouvrage = $em->getRepository(EtatStock::class)->find($id);
//
//        //Récupère la quantite existante de la classe ouvrage
//        $stockTotal = $ouvrage->getStockTotal();
//
//        //Création du formulaire
//        $form = $this->createForm(EtatStockType::class, $ouvrage);
//        $form->handleRequest($request);
//
//        //Vérification des données du formulaire
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            //Récupère le choix (entrée ou sortie) et la quantité
//            $quantiteEntree = $form->get('quantiteEntree')->getViewData();
//            $quantiteSortie = $form->get('quantiteSortie')->getViewData();
////            $nombre = $ouvrageForm->get('quantity')->getViewData();
//
//            //Si entrée
//            if ($quantiteEntree != null) {
////                $nbFinal = $stockTotal + $quantiteEntree;
////                $ouvrage->setStockTotal($nbFinal);
//                $ouvrage->setStockTotal($ouvrage->getStockTotal() + $ouvrage->getQuantiteEntree());
//                //Sinon sortie
//            }
//            if ($quantiteSortie != null) {
////                $nbFinal = $stockTotal - $quantiteSortie;
//                $ouvrage->setStockTotal($ouvrage->getStockTotal() - $ouvrage->getQuantiteSortie());
//                //Si quantité inférieur à 0, alors erreur
//                if ($stockTotal < 0) {
//                    $this->addFlash("succes", "Le stock ne peut pas être négatif !");
//
//                    return $this->render('etat_stock/ajouter.html.twig', [
//                       'ouvrageForm' => $form->createView(),
//                       'ouvrage' => $ouvrage,
//                    ]);
//
//                    //Sinon c'est good
//                }
////                else {
////                    $ouvrage->setStockTotal($stockTotal);
////                }
//            }
//            //Envoi des informations saisie à la BDD
//            $em->persist($ouvrage);
//            $em->flush();
//            $this->addFlash("success", "La quantité a été modifié avec succès !");
//            return $this->redirectToRoute('ouvrage_search', array('id' => $ouvrage->getId()));
//        }
//        return $this->render('etat_stock/ajouter.html.twig', [
//            'form_title' => 'Etat stock',
//            'form' => $form->createView(),
//            'ouvrage' => $ouvrage,
//            ]);
//    }



        /**
         * @Route("/etatStocks", name="etatStocks")
         */
    public function etatStocks()
{
    if (!$this->getUser()) {
        $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
        return $this->redirectToRoute('home');
    }
    $etatStocks = $this->getDoctrine()->getRepository(EtatStock::class)->findAll();

    return $this->render('etat_stock/detail.html.twig', [
        'form_title' => 'Liste des modifications des stocks',
        'etatStocks' => $etatStocks
    ]);
}

    /**
     * @Route("/updateEtatStock/{id}", name="updateEtatStock")
     */
    public function updateEtatStock(Request $request, int $id, EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }

        $em = $this->getDoctrine()->getManager();
        $etatStock = $em->getRepository(EtatStock::class)->find($id);
        $form = $this->createForm(EtatStockType::class, $etatStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            //En cas de succès de la modification, je suis retourné sur la page de la liste
            $this->addFlash("success", "modification éffectuée");
            return $this->redirectToRoute('etatStocks');
        }

        return $this->render('etat_stock/modifier.html.twig', [
            'form_title' => 'Faire une modification de l\'état des stocks',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteEtatStock/{id}", name="deleteEtatStock")
     */
    public function deleteEtatStock(EntityManagerInterface $em, int $id)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();
        $etatStock = $em->getRepository(EtatStock::class)->find($id);
        $em->remove($etatStock);
        $em->flush();

        return $this->redirectToRoute('etatStocks');
    }


}
