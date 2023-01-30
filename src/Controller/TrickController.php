<?php

namespace App\Controller;




use App\Entity\Image;
use App\Entity\Trick;
use DateTimeInterface;
use App\Entity\Message;
use App\Form\TrickType;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/{slug}", name="trick")
     */
    public function showTrick(string $slug, Request $request, TrickRepository $trickRepository, 
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
        $messages = $messageRepository->findPaginatedMessages($trick, 
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
            'messages' => $messages,
            'form'=> $form->createView()
        ]);
    }


        /**
     * @Route("/new", name="new_trick", methods={"GET", "POST"})
     */
    public function new(Request $request, TrickRepository $trickRepository, SluggerInterface $slugger): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recuperation des images transmises
            ///** @var UploadedFile $imageFiles */
            $imageFiles = $form->get('images')->getData();

            foreach($imageFiles as $imageFile){

                //generer un nouveau nom de fichier
                $newFileName = md5(uniqid()).'.'. $imageFile->guessExtension();
                //copier le fichier dans dossier uploads
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFileName
                );
                //stocker le nom de l'image dans la base de donnees 
                $image = new Image();
                $image->setName($newFileName);
                //ajouter l'image dans la table trick
                $trick->setImageFilename($newFileName);
                $trick->addImage($image);
            }
            
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
    public function edit(int $id, Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        
        $this->denyAccessUnlessGranted('trick_edit', $trick);    
      
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            //recuperation des images transmises
            $imageFiles = $form->get('images')->getData();

            foreach($imageFiles as $imageFile){

                //generer un nouveau nom de fichier
                $newFileName = md5(uniqid()).'.'. $imageFile->guessExtension();
                //copier le fichier dans dossier uploads
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFileName
                );
                //stocker le nom de l'image dans la base de donnees 
                $image = new Image();
                $image->setName($newFileName);
                //ajouter l'image dans la table trick
                $trick->setImageFilename($newFileName);
                $trick->addImage($image);
            }

        

            $this->getDoctrine()->getManager()->flush();
            

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }    

        $flashMessage = $this->addFlash('success', 'Votre modification a ete enregistree !');

        


        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form
        ]);
    }


    /**
     * @Route("/{id}", name="delete_trick", methods={"GET", "POST"})
     */
    public function delete(int $id, Request $request, TrickRepository $trickRepository): Response
    {
        $trick = $trickRepository->find($id);
        

        $this->denyAccessUnlessGranted('trick_delete', $trick, 'Vous ne pouvez pas supprimer cette figure');

        // if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);

            $flashMessage = $this->addFlash('success', 'Votre figure a ete supprimee !');

        //}

        
    }

    /**
     * @Route("/remove/image/{id}", name="remove_trick_image", methods={"GET", "DELETE"})
     */
    public function removeImage( int $id, Request $request, ImageRepository $imageRepository, 
                                EntityManagerInterface $em)
    {

        $image = new image();
        $image = $imageRepository->find($id);
        // $image = $trick->getImages->getId();
        
        //On recupere le nom de l'image
        $name = $image->getName();
        //On supprime le fichier
        if(file_exists($name)){
            unlink($this->getParameter('images_directory').'/'.$name);
        }    

        //On supprime l'image de la base de donnees (de la table trick)       
        $em->remove($image);
        $em->flush();
        
        return $this->redirectToRoute('remove_trick_image', [], Response::HTTP_SEE_OTHER);


    }

}
