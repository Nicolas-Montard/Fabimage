<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{


    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                return $this->redirectToRoute('app_book_new', ['error' => 1], Response::HTTP_SEE_OTHER);
            }
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', ['page' => 1], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/show/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(ArticleType::class, $article, ['image_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get("contentFr")->getData() || !$form->get("contentEs")->getData() || !$form->get("contentEt")->getData()){
                return $this->redirectToRoute('app_book_new', ['error' => 1], Response::HTTP_SEE_OTHER);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', ['page' => 1], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
            'error' => $request->query->get('error')
        ]);
    }

    #[Route('/{page}', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, $page): Response
    {
        $nbArticles = $articleRepository->findNb();
        $nbPages = floor($nbArticles[0][1] /10);
        if($nbArticles[0][1] % 10){
            $nbPages += 1;
        }
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findByPage($page),
            'newArticles' => $articleRepository->findByNewer(),
            'nbPages' => $nbPages,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager, Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED')){
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', ['page' => 1], Response::HTTP_SEE_OTHER);
    }
}
