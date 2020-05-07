<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FiliereController extends AbstractController
{
    /**
     * @Route("/filiere", name="filiere")
     */
    public function index()
    {
        return $this->render('filiere/index.html.twig', [
            'controller_name' => 'FiliereController',
        ]);
    }

    /**
     * @Route("/addFiliere", name="addFiliere")
     */
    public function addFiliere(EntityManagerInterface $em, Request $request)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $filiere = new Filiere();
        $filiereForm = $this->createForm(FiliereFormType::class, $filiere);
        $filiereForm->handleRequest($request);
        if ($filiereForm->isSubmitted() && $filiereForm->isValid()) {
            $em->persist($filiere);
            $em->flush();
            $this->addFlash("success", "Votre filière a bien été ajoutée !");
            return $this->redirectToRoute('filieres', array('id' => $filiere->getId()));
        }
        return $this->render('filiere/ajouter.html.twig', [
            'form_title' => 'Créer une nouvelle filière',
            'filiereForm' => $filiereForm->createView()
        ]);
    }


    /**
     * @Route("/filieres", name="filieres")
     */
    public function filieres()
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $filieres = $this->getDoctrine()->getRepository(Filiere::class)->findAll();

        return $this->render('filiere/detail.html.twig', [
            'form_title' => 'Liste des filieres',
            'filieres' => $filieres
        ]);
    }

    /**
     * @Route("/updateFiliere/{id}", name="updateFiliere")
     */
    public function updateFiliere(Request $request, int $id, EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();

        $filiere = $em->getRepository(Filiere::class)->find($id);
        $form = $this->createForm(FiliereFormType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            //En cas de succès de la modification, je suis retourné sur la page de la liste
            $this->addFlash("success", "modification effectuée");
            return $this->redirectToRoute('filieres');
        }

        return $this->render('filiere/modifier.html.twig', [
            'form_title' => 'Modifier une filière',
            'filiereForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteFiliere/{id}", name="deleteFiliere")
     */
    public function deleteFiliere(EntityManagerInterface $em, int $id)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();
        $filiere = $em->getRepository(Filiere::class)->find($id);
        $em->remove($filiere);
        $em->flush();

        return $this->redirectToRoute('filieres');
    }

}
