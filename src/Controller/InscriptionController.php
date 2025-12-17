<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscriptionController extends AbstractController
{
    #[Route('/number', name: 'inscription_number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('inscription/accueil.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/see/{id}', name: 'see')]
    public function voir(int $id): Response
    {
        return $this->render('inscription/voir.html.twig', [
            'id' => $id,
        ]);
    }
}
