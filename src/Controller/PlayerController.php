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
        dd($players);

        // dump($request);  non mi trova la variabile riquest
        // die;
    }
}
