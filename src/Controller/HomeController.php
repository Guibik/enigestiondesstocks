<?php

namespace App\Controller;


use App\Entity\SiteEntreposage;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function index()
    {
        if (!$this->getUser()) {
//            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('ouvrage_search');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    //Afficher la liste des sites disponibles

    /**
     * @Route("/sites_start", name="sites_start")
     */
    public function sites()
    {
        if (!$this->getUser()) {
//            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }
        $sites = $this->getDoctrine()->getRepository(SiteEntreposage::class)->findAll();

        return $this->render('pages/home.html.twig', [
            'form_title' => 'Liste des sites',
            'sites' => $sites
        ]);
    }
}
