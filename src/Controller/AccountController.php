<?php

namespace App\Controller;

use App\Form\CoachFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccountController extends AbstractController
{
  #[Route('/account', name: 'app_account')]
  #[IsGranted('ROLE_USER')]
  public function index(): Response
  {
    return $this->render('account/index.html.twig');
  }

  #[Route('/account/edit', name: 'app_account_edit')]
  #[IsGranted('ROLE_USER')]
  public function edit(Request $request, EntityManagerInterface $em, TranslatorInterface $translator): Response
  {
    $coach = $this->getUser();

    $form = $this->createForm(CoachFormType::class, $coach);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $coach->setUpdatedAt(new \DateTimeImmutable());
      $em->flush();

      $this->addFlash('success', $translator->trans('Account successfuly updated !'));

      return $this->redirectToRoute('app_account');
    }

    return $this->render('account/edit.html.twig', [
      'coach' => $coach,
      'coachForm' => $form->createView(),
    ]);
  }
}
