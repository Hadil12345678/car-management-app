<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VoitureController extends AbstractController
{
    #[Route('/voitures', name: 'voiture_list')]
    public function editAll(EntityManagerInterface $em): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $em->getRepository(Voiture::class)->findAll()
        ]);
    }

    #[Route('/voiture/add', name: 'voiture_add')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $voiture = new Voiture();

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($voiture);
            $em->flush();

            return $this->redirectToRoute('voiture_list');
        }

        return $this->render('voiture/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add Voiture'
        ]);
    }

    #[Route('/voiture/show/{id}', name: 'voiture_show')]
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture
        ]);
    }

    #[Route('/voiture/edit/{id}', name: 'voiture_edit')]
    public function edit(Voiture $voiture, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('voiture_list');
        }

        return $this->render('voiture/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit Voiture'
        ]);
    }

    #[Route('/voiture/delete/{id}', name: 'voiture_delete')]
    public function delete(Voiture $voiture, EntityManagerInterface $em): Response
    {
        $em->remove($voiture);
        $em->flush();

        return $this->redirectToRoute('voiture_list');
    }
}
