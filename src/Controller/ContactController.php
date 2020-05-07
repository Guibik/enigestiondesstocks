<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            //Envoie du message
            $message = (new \Swift_Message('Mail d un utilisateur via le site Gestion des stocks'))
                //Attribution de l'expéditeur
                ->setFrom('guillaume.grandval2019@campus-eni.fr')
                //Attribution du destinataire
                ->setTo('guillaume.grandval2019@campus-eni.fr')
                //Création du message
                ->setBody(
                    $this->renderView(
                        'contact/mail.html.twig', compact('contactFormData')
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Message was send');

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
//    /**
//     * @Route("/contact", name="contact")
//     */
//    public function index(Request $request, ContactNotification $notification): Response
//    {
//        $contact = new Contact();
//        $form = $this->createForm(ContactType::class, $contact);
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()) {
//            $notification->notify($contact);
//            $this->addFlash('succes', 'Votre email a bien été envoyé !');
//            return $this->redirectToRoute('home');
//        }
//
//        return $this->render('contact/index.html.twig', [
//            'controller_name' => 'ContactController',
//            'contact' => $contact,
//            'form' => $form->createView(),
//        ]);
//    }
}
