<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\BoutiqueRepository;
use App\Repository\TemoinageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BoutiqueRepository $boutiqueRepository, TemoinageRepository $temoinageRepository, Request $request, \Swift_Mailer $mailer): Response
    {
        $contact=new Contact();
        $form=$this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //envoie du email
            $message = (new \Swift_Message("Les petits commerçants"))
                ->setFrom('1christophejoubert@gmail.com')
                ->setTo($contact->getEmail())
                ->setBody(
                    $this->renderView('home/contact_email.html.twig', [
                        'message' => $contact
                    ]),
                    'text/html'
                );
            $mailer->send($message);
        }
        return $this->render('home/index.html.twig', [
            'boutiques' => $boutiqueRepository->findByRecentBoutique(),
            'temoinages' => $temoinageRepository->findByRecentTemoinage(),
            'contactForm' => $form->createView()
        ]);
    }
}
