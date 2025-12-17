<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MarqueController extends AbstractController
{
    // 📌 LIST ALL MARQUES
    #[Route('/marque', name: 'marque_list')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('marque/index.html.twig', [
            'marques' => $em->getRepository(Marque::class)->findAll(),
        ]);
    }

    // ➕ ADD MARQUE
    #[Route('/marque/add', name: 'marque_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $marque = new Marque();
        $marque->setCreatedAt(new \DateTime());

        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($marque);
            $em->flush();

            return $this->redirectToRoute('marque_list');
        }

        return $this->render('marque/ajouter.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add Marque',
        ]);
    }

    // ✏️ EDIT MARQUE
    #[Route('/marque/edit/{id}', name: 'marque_edit')]
    public function edit(Marque $marque, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('marque_list');
        }

        return $this->render('marque/ajouter.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit Marque',
        ]);
    }

    // 🗑️ DELETE MARQUE
    #[Route('/marque/delete/{id}', name: 'marque_delete')]
    public function delete(Marque $marque, EntityManagerInterface $em): Response
    {
        $em->remove($marque);
        $em->flush();

        return $this->redirectToRoute('marque_list');
    }
}
