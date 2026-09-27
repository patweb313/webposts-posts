<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function posts(PostRepository $repository): Response
    {
        // Récupère tous les enregistrements selon l'ordre d'écriture en DB
        // $posts = $repository->findAll();
        // Récupère les enregistrements suivants des critères, tris et limit
        $posts = $repository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
        );
        return $this->render('post/posts.html.twig', [
           'posts' => $posts,
        ]);
    }

    #[Route('/post/{slug}', name: 'app_post')]
    public function post(PostRepository $repository, string $slug): Response
    {
        $post = $repository->findOneBy(
            ['slug' => $slug]
        );
        return $this->render('post/post.html.twig', [
            'post' => $post,
        ]);
    }
}
