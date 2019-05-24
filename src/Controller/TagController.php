<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Tag;


class TagController extends AbstractController
{
    /**
     * Getting a list of all articles from a tag
     *
     * @param Tag tag to list
     *
     * @Route("/tag/{name}",
     *     name="show_tag")
     *  @return Response A response instance
     */
    public function showByTag(Tag $tag) : Response
    {

        $articles = $tag->getArticles();
        return $this->render(
            'blog/tags.html.twig',
            [
                'articles' => $articles,
                'tag' => $tag
            ]
        );
    }
}