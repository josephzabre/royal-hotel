<?php

namespace App\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Messages;
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
        $form=$this->createFormBuilder()
        ->add('name',TextType::class , ['attr' =>[
            'placeholder'=>'entrez votre nom',
            'class'=>'form-control'
        ]
        ])
        ->add('email', EmailType::class, ['attr' =>[
            'placeholder'=>'entrez votre addresse mail',
            'class'=>'form-control'
        ]
        ])
        ->add('message', TextareaType::class, ['attr' =>[
            'placeholder'=>'entrez votre message',
            'class'=>'form-control'
        ]
        ])
       
        ->getForm()
        ;
        $formulaire=$form->createView();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $messages= new Messages;
            $data=$form->getData();
            $name=$data['name'];
            $email=$data['email'];
            $message=$data['message'];
            $date= new \DateTimeImmutable();
            $messages->setExpediteur($name);
            $messages->setMail($email);
            $messages->setMessage($message);
            $messages->setCreatedAt($date);
            $em->persist($messages);
            $em->flush();


        }
        return $this->render('home/reservation.html.twig', compact('news', 'slides', 'formulaire'));
    }

}
