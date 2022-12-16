<?php

namespace App\Controller;




use App\Entity\Trick;
use DateTimeInterface;
use App\Entity\Message;
use App\Form\TrickType;
use App\Form\MessageType;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/{slug}", name="trick")
     */
    public function showTrick($slug, Request $request, TrickRepository $trickRepository, 
        Trick $trick, MessageRepository $messageRepository,  
        UserRepository $userRepository,
        PaginatorInterface $paginator): Response
    {       
        $trick = $trickRepository->findOneBy(['slug' =>$slug]);


        //Partie: messages (espace de discussion dedie a une figure)
        
        //Formulaire d'ajout d'un message
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        $data = $trick->getMessage();

        //On va chercher le numero de page dans l'url
        $page = $request->query->getInt('page', 1);

        //Liste des messages laisses sur une figure
        $messages = $messageRepository->findPaginatedMessages(
            $page, 3
        );

        //Traitement du formulaire         
        if ($form->isSubmitted() && $form->isValid()) {
            
            $message->setCreatedAd(new \DateTime('now'));
            $message->setTrick($trick);   
            $message->setUser($this->getUser());   

            $messageRepository->add($message, true);
            
            return $this->redirectToRoute('trick', ['slug' =>$trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            // 'messages' => $messageRepository->findAll(),
            'messages' => $messages,
            'form'=> $form->createView()
        ]);
    }


        /**
     * @Route("/new", name="new_trick", methods={"GET", "POST"})
     */
    public function new(Request $request, TrickRepository $trickRepository): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // /** @var UploadedFile $videoFile */
            // $fileUploader = new FileUploader;
            // $video = $form->get('video')->getData();
            // if ($video) {
            //     $videoFile = $fileUploader->upload($video);
            //     $trick->setVideoFile($videoFile);
            // }
            $trick->getCreatedAt(new \DateTime('now'));  
            $trick->setUser($this->getUser());   

            $trickRepository->add($trick, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        $flashMessage = $this->addFlash('success', 'Votre figure a ete creee avec succes !');

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="edit_trick", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
            $this->denyAccessUnlessGranted('trick_edit', $trick);       
        
            $form = $this->createForm(TrickType::class, $trick);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //$trick->setUser($this->getUser());   

                $trickRepository->add($trick, true);

                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }

            $flashMessage = $this->addFlash('success', 'Votre modification a ete enregistree !');

        // $flashMessage = $this->addFlash('danger', 'Attention, vous ne pouvez pas modifier cette figure');


        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form
        ]);
    }


    /**
     * @Route("/{id}", name="delete_trick", methods={"GET", "POST"})
     */
    public function delete(Request $request, TrickRepository $trickRepository): Response
    {
        $trick = new Trick;
        
        $this->denyAccessUnlessGranted('trick_delete', $trick, 'Vous ne pouvez pas supprimer cette figure');

        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);

        $flashMessage = $this->addFlash('success', 'Votre figure a ete supprimee !');

    }


}
