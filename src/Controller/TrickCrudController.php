<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trick/crud")
 */
class TrickCrudController extends AbstractController
{
    /**
     * @Route("/", name="app_trick_crud_index", methods={"GET"})
     */
    // public function index(TrickRepository $trickRepository): Response
    // {
    //     return $this->render('trick_crud/index.html.twig', [
    //         'tricks' => $trickRepository->findAll(),
    //     ]);
    // }

    /**
     * @Route("/new", name="app_trick_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TrickRepository $trickRepository): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickRepository->add($trick, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick_crud/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_trick_crud_show", methods={"GET"})
     */
    // public function show(Trick $trick): Response
    // {
    //     return $this->render('trick_crud/show.html.twig', [
    //         'trick' => $trick,
    //     ]);
    // }

    /**
     * @Route("/{id}/edit", name="app_trick_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickRepository->add($trick, true);

            return $this->redirectToRoute('app_trick_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick_crud/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_trick_crud_delete", methods={"POST"})
     */
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }

        return $this->redirectToRoute('app_trick_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
