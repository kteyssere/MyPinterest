<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Reaction;
use App\Entity\User;
use App\Repository\ReactionRepository;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReactionController extends AbstractController
{
    #[Route('/reactions', name: 'get_all_reactions', methods: ['GET'])]
    public function getAllReactions(ReactionRepository $reactionRepository): JsonResponse
    {
        // Récupérer toutes les réactions
        $reactions = $reactionRepository->findAll();

        // Transformer les données en un format lisible
        $responseData = [];
        foreach ($reactions as $reaction) {
            $responseData[] = [
                'id' => $reaction->getId(),
                'user' => $reaction->getUser()->getId(),
                'picture' => $reaction->getPicture()->getId(),
                'likeReaction' => $reaction->isLikeReaction(),
                'dislikeReaction' => $reaction->isDislikeReaction(),
            ];
        }

        return new JsonResponse($responseData);
    }

    #[Route('/picture/{id}/react/user/{userId}', name: 'create_or_update_reaction', methods: ['POST'])]
    public function createOrUpdateReaction(
        int $id,
        int $userId,
        Request $request,
        PictureRepository $pictureRepository,
        ReactionRepository $reactionRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        // Récupérer l'utilisateur par son ID
        $user = $entityManager->getRepository(User::class)->find($userId);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Récupérer l'image sur laquelle réagir
        $picture = $pictureRepository->find($id);
        if (!$picture) {
            return new JsonResponse(['error' => 'Picture not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Récupérer les données envoyées dans la requête
        $data = json_decode($request->getContent(), true);
        $like = $data['likeReaction'] ?? false;
        $dislike = $data['dislikeReaction'] ?? false;

        // Validation : un utilisateur ne peut pas liker et disliker en même temps
        if ($like && $dislike) {
            return new JsonResponse(['error' => 'Cannot like and dislike at the same time'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Vérifier si une réaction existe déjà
        $reaction = $reactionRepository->findOneBy(['user' => $user, 'picture' => $picture]);
        if (!$reaction) {
            // Si aucune réaction, en créer une
            $reaction = new Reaction();
            $reaction->setUser($user);
            $reaction->setPicture($picture);
        }

        // Mettre à jour la réaction
        $reaction->setLikeReaction($like);
        $reaction->setDislikeReaction($dislike);

        $entityManager->persist($reaction);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Reaction successfully updated']);
    }
}