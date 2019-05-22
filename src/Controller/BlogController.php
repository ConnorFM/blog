<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleSearchType;




class BlogController extends AbstractController
{
    /**
    * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
     public function index(Request $request): Response
     {
          $form = $this->createForm(
              ArticleSearchType::class);
          $form->handleRequest($request);

           if ($form->isSubmitted())
            {
            $data = $form->getData();
            }

          $articles = $this->getDoctrine()
              ->getRepository(Article::class)
              ->findAll();

          if (!$articles) {
              throw $this->createNotFoundException(
              'No article found in article\'s table.'
              );
          }


          return $this->render(
                  'blog/index.html.twig',
                  ['articles' => $articles,
                    'form' => $form->createView()]
          );
    }


    /**
    * @Route("/blog/list/{page<\d+>?1}", name="blog_list")
    */
    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }

  /**
   * Getting a article with a formatted slug for title
   *
   * @param string $slug The slugger
   *
   * @Route("/{slug<^[a-z0-9-]+$>}",
   *     defaults={"slug" = null},
   *     name="show_article")
   *  @return Response A response instance
   */
 /**  public function show(string $slug) : Response
   {
       if (!$slug) {
              throw $this
              ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
          }

       $slug = preg_replace(
        '/-/',
        ' ', ucwords(trim(strip_tags($slug)), "-")
          );

       $article = $this->getDoctrine()
              ->getRepository(Article::class)
              ->findOneBy(['title' => mb_strtolower($slug)]);

       if (!$article) {
            throw $this->createNotFoundException(
            'No article with '.$slug.' title, found in article\'s table.'
        );
      }

       return $this->render(
       'blog/showarticle.html.twig',
        [
                'article' => $article,
                'slug' => $slug,

        ]
      );
  }*/

  /**
  * Getting 3 articles from its category
  * @Route("/category/{categoryName}", name="category_name")
  */
  /**public function showByCategory(string $categoryName)
    {
      $category = $this->getDoctrine()
          ->getRepository(Category::class)
          //->findOneByName($categoryName)
          //->getId();
          ->findOneByName($categoryName);
      //$articles = $this->getDoctrine()->getRepository(Article::class)
            //->findByCategory($category);

      $articles = $category->getArticles();


      return $this->render(
          'blog/category.html.twig',
          ['articles' => $articles]
          );
    }*/


   /**
   * @Route("/article/{id}", name="article_show")
   */
  public function show(Article $article): Response
    {
        return $this->render('blog/article.html.twig', ['article'=>$article]);
    }



  /**
   * @Route("/category/{name}", name="category_show")
   */
  public function showByCategory(Category $category): Response
    {
      $articles=$category->getArticles();

      return $this->render('blog/category.html.twig', ['articles'=>$articles,
                                                        'categories'=>$category]);
    }

}
