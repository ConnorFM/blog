<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_index")
    */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Foucauld',
        ]);
    }


    /**
    * @Route("/blog/list/{page<\d+>?1}", name="blog_list")
    */
    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/blog/show/{slug}",
     *     defaults={"slug"= "Article Sans Titre"},
     *     requirements={"slug"="([a-z]|\d|-)+"}),
     *     name="show_slug"
     * )
     */
    public function show($slug)
    {
        $slug=ucwords(str_replace('-', ' ', $slug));
        return $this->render('blog/show.html.twig', ['slug' =>$slug]);
    }
}
