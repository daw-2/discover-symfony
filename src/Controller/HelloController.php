<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello/{name}", name="hello", requirements={"name"="[a-z]{3,8}"})
     */
    public function index($name = 'matthieu')
    {
        return $this->render('hello/index.html.twig', [
            'name' => ucfirst($name),
        ]);
    }
}
