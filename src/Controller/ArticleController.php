<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }
    // CRUD for Article (title, article_post)
    #[Route('/article/create', name: 'app_article_create')]
    public function create(EntityManagerInterface $entityManager): JsonResponse
    {
        $article = new Article();
        $article->setTitle('Article Title');
        $article->setArticlePost('Article Post');
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->json([
            'message' => 'Article created successfully',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }

    #[Route('/article/read/{id}', name: 'app_article_read')]
    public function read(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        return $this->json([
            'message' => 'Article read successfully',
            'path' => 'src/Controller/ArticleController.php',
            // Create a json object from the Article object
            'article' => [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'article_post' => $article->getArticlePost(),
            ],
        ]);
    }

    #[Route('/article/update/{id}', name: 'app_article_update')]
    public function update(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        $article->setTitle('Article Title Updated');
        $article->setArticlePost('Article Post Updated');
        $entityManager->flush();
        return $this->json([
            'message' => 'Article updated successfully',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }

    #[Route('/article/delete/{id}', name: 'app_article_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->json([
            'message' => 'Article deleted successfully',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }

    // find all the articles
    #[Route('/article/findall', name: 'app_article_findall')]
    public function findAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        $articlesArray = [];
        foreach ($articles as $article) {
            $articlesArray[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'article_post' => $article->getArticlePost(),
            ];
        }
        return $this->json([
            'message' => 'Articles found successfully',
            'path' => 'src/Controller/ArticleController.php',
            'articles' => $articlesArray,
        ]);
    }
}
