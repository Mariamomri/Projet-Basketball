<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LikeController extends AbstractController
{
  #[Route('/like/player/{id}', name: 'like.player', methods: ['GET'])]
  #[IsGranted('ROLE_USER')]
  public function like(Player $player, EntityManagerInterface $manager): Response
  {
    $coach = $this->getUser();

    if ($player->isLikedByCoach($coach)) {
      $player->removeLike($coach);
      $manager->flush();

      return $this->json([
        'message' => 'Le like a été supprimé.',
        'nbLike' => $player->howManyLikes(),
        'liked' => false,
      ]);
    }

    $player->addLike($coach);
    $manager->flush();

    return $this->json([
      'message' => 'Le like a été ajouté.',
      'nbLike' => $player->howManyLikes(),
      'liked' => true,
    ]);
  }
}
