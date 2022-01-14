<?php

namespace App\Controller;
use App\Form\MessagesType;
use App\Entity\Commandes;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Messages;
use App\Repository\CommandesRepository;
use App\Repository\NewsRepository;
use App\Repository\PostsRepository;
use App\Repository\ServiceRepository;
use App\Repository\SlidesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostsRepository $postsRepository, NewsRepository $newsRepository, SlidesRepository $slidesRepository ): Response
    {
        $slides=$slidesRepository->findAll();
        $posts=$postsRepository->findAll();
        $news=$newsRepository->findAll();
        return $this->render('home/index.html.twig', compact('posts', 'news', 'slides'));

    }
    /**
     * @Route("/about", name="about")
     */
    public function about(ServiceRepository $serviceRepository, NewsRepository $newsRepository): Response
    {
        $services=$serviceRepository->findAll();
        $news=$newsRepository->findAll();
        return $this->render('home/about.html.twig', compact('services', 'news') );

    }
     /**
     * @Route("home/category/{id}", name="show_category")
     */
    public function allOfCategory($id, PostsRepository $postsRepository): Response
    {
        $posts =$postsRepository->findBy(array('category' => $id));
        return $this->render('includes/category.html.twig', compact('posts'));
    }
    
     /**
     * @Route("/chambres/{id}", name="chambres")
     */
    public function chambre($id, PostsRepository $postsRepository, NewsRepository $newsRepository,SlidesRepository $slidesRepository ): Response
    {
        $slides=$slidesRepository->findAll();
        $posts =$postsRepository->findBy(array('category' => $id));
        $news=$newsRepository->findAll();
        return $this->render('home/chambres.html.twig', compact('posts', 'news', 'slides'));
    }

     /**
     * @Route("/suites/{id}", name="suites")
     */
    public function suite($id, PostsRepository $postsRepository, NewsRepository $newsRepository, SlidesRepository $slidesRepository ): Response
    {
        $slides=$slidesRepository->findAll();
        $posts =$postsRepository->findBy(array('category' => $id));
        $news=$newsRepository->findAll();
        return $this->render('home/suites.html.twig', compact('posts', 'news', 'slides'));
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details($id, PostsRepository $postsRepository,NewsRepository $newsRepository, SlidesRepository $slidesRepository): Response
    {
        $slides=$slidesRepository->findAll();
        $post =$postsRepository->find($id);
        $news=$newsRepository->findAll();
        return $this->render('home/details.html.twig', compact('post', 'news', 'slides'));
    }
    /**
     * @Route("/reservation", name="reservation", methods={"GET", "POST"} )
     */
    public function reservation(NewsRepository $newsRepository, SlidesRepository $slidesRepository, Request $request, EntityManagerInterface $em): Response
    {
        $slides=$slidesRepository->findAll();
        $news=$newsRepository->findAll();

        $messages=new Messages;
        $form = $this->createForm(MessagesType::class, $messages);
        $formulaire=$form->createView();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            
            $em->persist($messages);
            $em->flush();

        }
        return $this->render('home/reservation.html.twig', compact('news', 'slides', 'formulaire'));
    }
     /**
     * @Route("/commander/{id}", name="commander", methods={"GET", "POST"} )
     */
    public function commander($id, PostsRepository $postsRepository, EntityManagerInterface $em, NewsRepository $newsRepository, SlidesRepository $slidesRepository )
    {
        $slides=$slidesRepository->findAll();
        $news=$newsRepository->findAll();
        $post =$postsRepository->find($id);
        $commande= new Commandes;
        $commande->setArticles($post->getTitle());
        $commande->setPrix($post->getPrix());
        $em->persist($commande);
        $em->flush();
        return $this->render('home/details.html.twig', compact('post', 'news', 'slides'));
        
        
    }
}
