<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function index(PlayerRepository $repository): Response
    {
        $players = $repository->findAll();
        // dd($players);

        // dump($request);  non mi trova la variabile request
        // die;

        return $this->render('player/index.html.twig', [
            'players' => $players,
        ]);
    }

    #[Route('/players/{slug}-{id}', name: 'app_player_show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(string $slug, int $id, PlayerRepository $repository): Response
    {
        $player = $repository->find($id);

        return $this->render('player/show.html.twig', [
            'slug'   => $slug,
            'id'     => $id,
            'player' => $player,
        ]);
    }
}
