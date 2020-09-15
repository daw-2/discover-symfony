<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        dump(['a' => 1, 'b' => 2]);
        dump($request);

        $name = '<script>Matthieu</script>';

        // return new Response('<body>ACCUEIL</body>');
        return $this->render('home.html.twig', [
            'name' => $name,
        ]);
    }
}
