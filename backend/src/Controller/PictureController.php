<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/pictures', name: 'get_all_pictures', methods: ['GET'])]
    public function getAllPictures(PictureRepository $pictureRepository): JsonResponse
    {
        // Récupérer toutes les images
        $pictures = $pictureRepository->findAll();

        // Transformer les données en un format lisible (ex: JSON)
        $responseData = [];
        foreach ($pictures as $picture) {
            $responseData[] = [
                'id' => $picture->getId(),
                'filename' => $picture->getFilename(),
                'path' => $picture->getPath(),
                'width' => $picture->getWidth(),
                'height' => $picture->getHeight(),
                'createdAt' => $picture->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        }

        // Retourner les données sous forme de réponse JSON
        return new JsonResponse($responseData);
    }
}