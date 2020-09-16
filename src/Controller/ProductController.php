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
            ['id' => 4, 'name' => 'iPhone XS', 'slug' => 'iphone-xs', 'price' => 1199],
            ['id' => 5, 'name' => 'iPhone XS', 'slug' => 'iphone-xs', 'price' => 1199],
            ['id' => 6, 'name' => 'iPhone XS', 'slug' => 'iphone-xs', 'price' => 1199],
            ['id' => 7, 'name' => 'iPhone XS', 'slug' => 'iphone-xs', 'price' => 1199],
        ];
    }

    /**
     * @Route("/product/{page}", name="product_index")
     */
    public function index($page = 1)
    {
        // page 1 => 0 => (1 - 1) * 2
        // page 2 => 2 => (2 - 1) * 2
        // page 3 => 4 => (3 - 1) * 2

        $itemByPage = 2;
        $offset = ($page - 1) * $itemByPage;
        $products = array_slice($this->products, $offset, $itemByPage);

        if (empty($products)) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
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
