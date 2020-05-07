<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Ouvrage;
use App\Form\OuvrageSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/ouvrage_search", name="ouvrage_search")
     */
    public function index(Request $request)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté.");
            return $this->redirectToRoute('home');
        }

        $data = new SearchData();
        $form = $this->createForm(OuvrageSearchType::class, $data);
        $form->handleRequest($request);
        $ouvrages = $this->getDoctrine()->getRepository(Ouvrage::class)->findSearch($data);

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchControoler',
            'form_title' => 'Liste des ouvrages',
            'form_title_search' => 'Rechercher',
            'ouvrages' => $ouvrages,
            'form' => $form->createView()
        ]);
    }
}
