<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, LoggerInterface $logger, SessionInterface $session)
    {
        dump(['a' => 1, 'b' => 2]);
        dump($request);

        $name = '<script>alert("Matthieu");</script>';

        dump($logger);
        $logger->info('Ok, on va logger');
        $session->set('user', 'toto');
        dump($session);

        // return new Response('<body>ACCUEIL</body>');
        return $this->render('home.html.twig', [
            'name' => $name,
        ]);
    }
}
