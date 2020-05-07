<?php

namespace App\Controller;

use App\Entity\Technologie;
use App\Form\TechnologieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TechnologieController extends AbstractController
{
    /**
     * @Route("/technologie", name="technologie")
     */
    public function index()
    {
        return $this->render('technologie/index.html.twig', [
            'controller_name' => 'TechnologieController',
        ]);
    }

    /**
     * @Route("/addTechno", name="addTechno")
     */
    public function addTechno(EntityManagerInterface $em, Request $request)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $techno = new Technologie();
        $technoForm = $this->createForm(TechnologieFormType::class, $techno);
        $technoForm->handleRequest($request);
        if ($technoForm->isSubmitted() && $technoForm->isValid()) {
            $em->persist($techno);
            $em->flush();
            $this->addFlash("success", "Votre technologie a bien été ajoutée !");
            return $this->redirectToRoute('technos', array('id' => $techno->getId()));
        }
        return $this->render('technologie/ajouter.html.twig', [
            'form_title' => 'Créer une nouvelle techno',
            'technoForm' => $technoForm->createView()
        ]);
    }


    /**
     * @Route("/technos", name="technos")
     */
    public function technos()
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $technos = $this->getDoctrine()->getRepository(Technologie::class)->findAll();

        return $this->render('technologie/detail.html.twig', [
            'form_title' => 'Liste des technologies',
            'technos' => $technos
        ]);
    }

    /**
     * @Route("/updateTechno/{id}", name="updateTechno")
     */
    public function updateTechno(Request $request, int $id, EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();

        $techno = $em->getRepository(Technologie::class)->find($id);
        $form = $this->createForm(TechnologieFormType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            //En cas de succès de la modification, je suis retourné sur la page de la liste
            $this->addFlash("success", "modification effectuée");
            return $this->redirectToRoute('technos');
        }

        return $this->render('technologie/modifier.html.twig', [
            'form_title' => 'Modifier une technologie',
            'technoForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteTechno/{id}", name="deleteTechno")
     */
    public function deleteTechno(EntityManagerInterface $em, int $id)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();
        $techno = $em->getRepository(Technologie::class)->find($id);
        $em->remove($techno);
        $em->flush();

        return $this->redirectToRoute('technos');
    }

}
