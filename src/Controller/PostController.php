<?php

namespace App\Controller;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post/article-1", name="post")
     */
    public function show(MarkdownParserInterface $parser, AdapterInterface $cache)
    {
        $markdown = '# Titre de l\'article

Contenu de l\'articleeeee

- Item 1
- Item 2
- Item 3

[Un lien](https://google.fr)';

        // On mets en cache le html si le markdown n'a pas changé
        $item = $cache->getItem('post_'.md5($markdown)); // post_af56fed4323
        dump($item);

        if ($item->isHit()) { // Est-ce que le md5 est en cache
            $html = $item->get();
        } else {
            // On transforme le markdown en HTML
            sleep(2);
            $html = $parser->transformMarkdown($markdown);
            // On mets en cache le html
            $item->set($html);
            $cache->save($item);
        }

        dump($html); // <h1>Titre de l'article</h1>

        return $this->render('post/index.html.twig', [
            'content' => $html,

            // 2ème méthode
            'markdown' => $markdown,
        ]);
    }
}
