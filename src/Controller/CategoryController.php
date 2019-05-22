<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="add_category")
     * @return Response A response instance
     */
    public function add(Request $request) : Response
    {
        $category = new Category();
        $form = $this->createForm(
            CategoryType::class,
            $category,
            ['method' => Request::METHOD_GET]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('add_category');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
