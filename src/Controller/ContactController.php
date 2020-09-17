<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($contact);

            $this->addFlash(
                'success',
                'Bonjour '.$contact->name.', nous avons recu votre demande'
            );

            // Envoi de l'email...
            $email = (new Email())
                ->from($contact->email)
                ->to('admin@monsite.com')
                ->subject('Demande de contact')
                ->text($contact->name.' a fait une demande : '.$contact->getMessage());

            $mailer->send($email);

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
