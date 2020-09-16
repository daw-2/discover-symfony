<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    /**
     * Le paramètre doit obligatoirement être un nombre 
     *
     * @Route("/demo/{id}", name="demo", requirements={"id"="\d+"})
     */
    public function index($id = null)
    {
        dump($id);

        $users = [
            ['id' => 1],
            ['id' => 2],
        ];

        return $this->render('demo/index.html.twig', [
            'id' => $id,
            'users' => $users,
        ]);
    }
}
