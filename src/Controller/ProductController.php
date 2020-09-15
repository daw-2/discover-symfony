<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Etape 1: Définir toutes les routes du TP (Attention au return)
 * Etape 2: Initialiser un tableau de produits dans le constructeur
 *          On utilisera une propriété products
 */
class ProductController extends AbstractController
{
    private $products;

    public function __construct()
    {
        $this->products = []; 
    }

    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
