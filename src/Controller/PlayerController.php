<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\JsonResponse; //return json 

use App\Entity\Player;
use App\Form\PlayerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Comment;
use App\Form\CommentType;

// use Symfony\Component\HttpFoundation\Request; l'ho utilizzata per il debug ma non fonziona

final class PlayerController extends AbstractController
{
    // #[Route('/player', name: 'app_player')]
    // public function index(): Response
    // {
    //     return $this->render('player/index.html.twig', [
    //         'controller_name' => 'PlayerController',
    //     ]);
    // }


    #[Route('/players', name: 'app_player')]
    public function index(PlayerRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $searchTerm = $request->query->get('q');

        $query = $repository->search($searchTerm)->getQuery();

        $players = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('player/index.html.twig', [
            'players' => $players,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/players/{slug}-{id}', name: 'app_player_show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(string $slug, int $id, PlayerRepository $repository, Request $request, EntityManagerInterface $em): Response
    {
        $player = $repository->find($id);

        $comment = new Comment();
        $comment->setPlayer($player);
        if ($this->getUser()) {
            $comment->setAuthor($this->getUser());
        }

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a bien été enregistré. Il sera soumis à modération dans les plus brefs délais.');

            return $this->redirectToRoute('app_player_show', ['slug' => $slug, 'id' => $id]);
        }

        return $this->render('player/show.html.twig', [
            'slug'   => $slug,
            'id'     => $id,
            'player' => $player,
            'form'   => $form->createView(),
        ]);
    }

    // retourner un json
    #[Route(path: '/playersjson/{slug}-{id}', name: 'app_player_show_json', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function showJson(string $slug, int $id): JsonResponse
    {
        return $this->json([
            'id'   => $id,
            'slug' => $slug,
        ]);
    } // in url faire http://127.0.0.1:8000/playersjson/lebron-james-1

    #[Route('/players/create', name: 'app_player_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            /**
             * @var User 
             */
            $user = $this->getUser();
            if (!$user->isVerified()) {
                $this->addFlash('error', 'You must confirm your email to create a Player !');
                return $this->redirectToRoute('app_player');
            }
        } else {
            $this->addFlash('error', 'You must login to create a Player !');
            return $this->redirectToRoute('app_login');
        }

        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player->setCoach($this->getUser());
            $em->persist($player);
            $em->flush();

            $this->addFlash('success', 'Le joueur ' . $player->getName() . ' a bien été créé');

            return $this->redirectToRoute('app_player');
        }

        return $this->render('player/create.html.twig', [
            'monForm' => $form,
        ]);
    }

    #[Route('/players/{id}/edit', name: 'app_player_edit', requirements: ['id' => '\d+'])]
    public function edit(Player $player, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            /**
             * @var User 
             */
            $user = $this->getUser();
            if (!$user->isVerified()) {
                $this->addFlash('error', 'You must confirm your email to edit a Player !');
                return $this->redirectToRoute('app_player');
            } elseif ($player->getCoach()->getEmail() !== $this->getUser()->getEmail()) {
                $this->addFlash('error', 'You must be the coach ' . $player->getCoach()->getEmail() . ' to edit this Player !');
                return $this->redirectToRoute('app_player');
            }
        } else {
            $this->addFlash('error', 'You must login to edit a Player !');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Le joueur ' . $player->getName() . ' a bien été modifié');

            return $this->redirectToRoute('app_player');
        }

        return $this->render('player/edit.html.twig', [
            'monForm' => $form,
            'player' => $player,
        ]);
    }

    #[Route('/players/{id}/delete', name: 'app_player_delete', requirements: ['id' => '\d+'])]
    public function delete(Player $player, EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            /**
             * @var User 
             */
            $user = $this->getUser();
            if (!$user->isVerified()) {
                $this->addFlash('error', 'You must confirm your email to delete a Player !');
                return $this->redirectToRoute('app_player');
            } elseif ($player->getCoach()->getEmail() !== $this->getUser()->getEmail()) {
                $this->addFlash('error', 'You must be the coach ' . $player->getCoach()->getEmail() . ' to delete this Player !');
                return $this->redirectToRoute('app_player');
            }
        } else {
            $this->addFlash('error', 'You must login to delete a Player !');
            return $this->redirectToRoute('app_login');
        }

        $em->remove($player);
        $em->flush();

        $this->addFlash('success', 'Le joueur a bien été supprimé');

        return $this->redirectToRoute('app_player');
    }
}
