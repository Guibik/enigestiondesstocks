<?php

namespace App\Controller;

use App\Entity\SiteEntreposage;
use App\Form\SiteEntreposageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SiteEntreposageController extends AbstractController
{
    /**
     * @Route("/site/entreposage", name="site_entreposage")
     */
    public function index(EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $siteRepository = $em->getRepository(SiteEntreposage::class);
        $site = $siteRepository->findAll();
        return $this->render('siteEntreposage/index.html.twig', [
            'site' => $site,
        ]);
    }

    /**
     * @Route("/admin/addSite", name="addSite")
     */
    public function addSite(EntityManagerInterface $em, Request $request)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $site = new SiteEntreposage();
        $siteForm = $this->createForm(SiteEntreposageType::class, $site);
        $siteForm->handleRequest($request);
        if ($siteForm->isSubmitted() && $siteForm->isValid()) {
            $em->persist($site);
            $em->flush();
            $this->addFlash("success", "Votre site a bien été ajouté !");
            return $this->redirectToRoute('sites', array('id' => $site->getId()));
        }
        return $this->render('siteEntreposage/ajouter.html.twig', [
            'form_title' => 'Créer un nouveau site',
            'siteForm' => $siteForm->createView()
        ]);
    }

//    Liste des sites enregistrés

    /**
     * @Route("/sites", name="sites")
     */
    public function sites()
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $sites = $this->getDoctrine()->getRepository(SiteEntreposage::class)->findAll();

        return $this->render('siteEntreposage/detail.html.twig', [
            'form_title' => 'Liste des sites',
            'sites' => $sites
        ]);
    }

    /**
     * @Route("/updateSite/{id}", name="updateSite")
     */
    public function updateSite(Request $request, int $id, EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();

        $site = $em->getRepository(SiteEntreposage::class)->find($id);
        $form = $this->createForm(SiteEntreposageType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

        //En cas de succès de la modification, je suis retourné sur la page de la liste
            $this->addFlash("success", "modification effectuée");
            return $this->redirectToRoute('sites');
        }

        return $this->render('siteEntreposage/modifier.html.twig', [
            'form_title' => 'Modifier un site',
            'siteForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/deleteSite/{id}", name="deleteSite")
     */
    public function deleteSite(EntityManagerInterface $em, int $id)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $em = $this->getDoctrine()->getManager();
        $site = $em->getRepository(SiteEntreposage::class)->find($id);
        $em->remove($site);
        $em->flush();

        return $this->redirectToRoute('sites');
    }

}
