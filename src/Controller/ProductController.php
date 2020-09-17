<?php

namespace App\Controller;

use App\Model\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            // ['id' => 1, 'name' => 'iPhone X', 'slug' => 'iphone-x', 'price' => 999],
            // ['id' => 2, 'name' => 'iPhone XR', 'slug' => 'iphone-xr', 'price' => 1099],
            // ['id' => 3, 'name' => 'iPhone XS', 'slug' => 'iphone-xs', 'price' => 1199],
            new Product('iPhone X', '2017', 'iphone-x', 999),
            new Product('iPhone XR', '2018', 'iphone-xr', 1099),
            new Product('iPhone XS', '2019', 'iphone-xs', 1199),
        ];
    }

    /**
     * @Route("/product/{page}", name="product_index", requirements={"page"="\d+"})
     */
    public function index($page = 1)
    {
        // page 1 => 0 => (1 - 1) * 2
        // page 2 => 2 => (2 - 1) * 2
        // page 3 => 4 => (3 - 1) * 2

        $itemByPage = 2;
        $totalPage = ceil(count($this->products) / $itemByPage);
        $offset = ($page - 1) * $itemByPage;
        $products = array_slice($this->products, $offset, $itemByPage);

        if (empty($products)) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'total_page' => $totalPage,
            'current_page' => $page,
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request)
    {
        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('name')
            ->add('description', TextareaType::class, [
                'label' => 'Ma description',
                'label_attr' => ['class' => 'text-success'],
            ])
            ->add('price')
            ->getForm();

        // On donne la request au formulaire pour qu'il
        // puisse traiter le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupèrer les données
            dump($form->getData());
            dump($product);
            dump($form->getData() === $product);

            // Envoyer un mail, ajouter à la BDD...
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
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
     * @Route("/product/order/{slug}", name="product_order")
     */
    public function order($slug)
    {
        foreach ($this->products as $product) {
            if ($slug === $product->slug) {
                $this->addFlash(
                    'success',
                    'Le produit '.$product->name.' a été commandé'
                );

                return $this->redirectToRoute('product_index');
            }
        }

        throw $this->createNotFoundException();
    } 

    /**
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        foreach ($this->products as $product) {
            if ($slug === $product->slug) {
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
