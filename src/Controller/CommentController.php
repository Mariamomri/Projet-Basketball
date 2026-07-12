<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommentController extends AbstractController
{
  #[Route('/comment/{id}', name: 'comment.delete')]
  #[IsGranted('ROLE_USER')]
  public function delete(Comment $comment, EntityManagerInterface $em, Request $request): Response
  {
    if ($comment->getAuthor() !== $this->getUser()) {
      $this->addFlash('error', 'Vous ne pouvez supprimer que vos propres commentaires !');
      return $this->redirectToRoute('app_player_show', [
        'slug' => $comment->getPlayer()->getSlug(),
        'id' => $comment->getPlayer()->getId(),
      ]);
    }

    if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
      $em->remove($comment);
      $em->flush();
    }

    $this->addFlash('success', 'Votre commentaire a bien été supprimé.');

    return $this->redirectToRoute('app_player_show', [
      'slug' => $comment->getPlayer()->getSlug(),
      'id' => $comment->getPlayer()->getId(),
    ]);
  }
}
