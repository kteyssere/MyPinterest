<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Picture;
use App\Entity\Reaction;
use App\Repository\PictureRepository;
use App\Repository\ReactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($data['password']); // Mot de passe enregistré en clair (pas recommandé en production)

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User registered successfully'], Response::HTTP_CREATED);
    }

    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            return new JsonResponse(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['message' => 'Login successful', 'user' => $lastUsername]);
    }

    #[Route('/gallery', name: 'gallery_view', methods: ['GET'])]
    public function viewGallery(PictureRepository $pictureRepository): Response
    {
        $pictures = $pictureRepository->findAll();

        $responseData = [];
        foreach ($pictures as $picture) {
            $likes = count(array_filter(
                $picture->getReactions()->toArray(),
                fn($reaction) => $reaction->isLikeReaction()
            ));
            $dislikes = count(array_filter(
                $picture->getReactions()->toArray(),
                fn($reaction) => $reaction->isDislikeReaction()
            ));

            $responseData[] = [
                'id' => $picture->getId(),
                'filename' => $picture->getFilename(),
                'likes' => $likes,
                'dislikes' => $dislikes,
            ];
        }

        return new JsonResponse($responseData);
    }

    #[Route('/picture/{id}/react', name: 'picture_react', methods: ['POST'])]
    public function react(
        int $id,
        Request $request,
        PictureRepository $pictureRepository,
        ReactionRepository $reactionRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $picture = $pictureRepository->find($id);
        if (!$picture) {
            return new JsonResponse(['error' => 'Picture not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $like = $data['likeReaction'] ?? false;
        $dislike = $data['dislikeReaction'] ?? false;

        if ($like && $dislike) {
            return new JsonResponse(['error' => 'Cannot like and dislike at the same time'], Response::HTTP_BAD_REQUEST);
        }

        $reaction = $reactionRepository->findOneBy(['user' => $user, 'picture' => $picture]);
        if (!$reaction) {
            $reaction = new Reaction();
            $reaction->setUser($user);
            $reaction->setPicture($picture);
        }

        $reaction->setLikeReaction($like);
        $reaction->setDislikeReaction($dislike);

        $entityManager->persist($reaction);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Reaction updated successfully']);
    }
}