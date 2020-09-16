<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $this->products = [
            ['id' => 1, 'name' => 'iPhone X', 'slug' => 'iphone-x', 'price' => 999],
            ['id' => 2, 'name' => 'iPhone XR', 'slug' => 'iphone-xr', 'price' => 1099],
            ['id' => 3, 'name' => 'iPhone XS', 'slug' => 'iphone-xs', 'price' => 1199],
        ];
    }

    /**
     * @Route("/product", name="product_index")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'products' => $this->products,
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {
        return $this->render('product/create.html.twig');
    }

    /**
     * @Route("/product/random", name="product_random")
     */
    public function random()
    {
        $product = $this->products[array_rand($this->products)];

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        foreach ($this->products as $product) {
            if ($slug === $product['slug']) {
                return $this->render('product/show.html.twig', [
                    'product' => $product,
                ]);
            }
        }

        throw $this->createNotFoundException();
    }

    /**
     * @Route("/product.json")
     */
    public function api(Request $request)
    {
        // Permet de vérifier que l'url est appellée via AJAX
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        return $this->json($this->products);
    }
}
