<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne')]

class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne')]
    public function index(ManagerRegistry $doctrine) : Response{
        $repository=$doctrine->getRepository(Personne::class);
        $personnes=$repository->findAll();
        return $this->render("personne\personne.html.twig",
        ['personnes'=>$personnes]
        );

    }

    #[Route('/all/{page?1}/{nbre?12}', name: 'all')]
    public function all(ManagerRegistry $doctrine,$page,$nbre) : Response{
        $repository=$doctrine->getRepository(Personne::class);
        $nbrePersonne=$repository->count([]);
        $nbrPage=ceil($nbrePersonne / $nbre);
        $personnes=$repository->findBy([],[],$nbre,($page-1)*$nbre);
        return $this->render("personne\personne.html.twig",
            ['personnes'=>$personnes,
                'isPaginated'=>true,
                'nbPage'=>$nbrPage,
                'page'=>$page,
                'nbre'=>$nbre
                ]
        );

    }

    #[Route('/{id<\d+>}', name: 'detail')]
    public function findid(Personne $personne = null) : Response{

        if(!$personne)
        {
            $this->addFlash('error',"la personne n'existe pas");
           return $this->redirectToRoute('personne');
        }
         return $this->render("personne\index.html.twig",
       ['personne'=>$personne]);
    }

    #[Route('/add', name: 'add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager=$doctrine->getManager();
        $personne=new Personne();
        $personne->setFirstname('safa');
        $personne->setName('oueslati');
        $personne->setAge(21);
        $personne->setJob('etudiante');
//        $personne1=new Personne();
//        $personne1->setFirstname('ahmed');
//        $personne1->setName('oueslati');
//        $personne1->setAge(30);
//        $personne1->setJob('ingénieur');

        $entityManager->persist($personne);
       // $entityManager->persist($personne1);
        $entityManager->flush();
        return $this->render('personne/index.html.twig',
            ['personne' => $personne]);
    }

    #[Route('/add2', name: 'add2')]
    public function add2Personne(ManagerRegistry $doctrine,Request $request): Response
    {
        $personne=new Personne();
        $form=$this->createForm(PersonneType::class,$personne);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $manager=$doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            $this->addFlash('succes',$personne->getFirstname()." a été ajouté avec succés");
            return $this->redirectToRoute("all");
        }
        else{
        return $this->render("personne/add-personne.html.twig",[
            'form'=> $form->createView()
        ]);
        }
    }



    #[Route('/delete/{id<\d+>}', name: 'delete')]
    public function deletePersonne(Personne $personne=null,ManagerRegistry $doctrine): Response
    {
        if($personne){
            $manager=$doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('succes',"la personne a été supprimé avec succés");
        }
        else{
            $this->addFlash('error',"la personne n'existe pas");
        }
        return $this->redirectToRoute("all");
    }

    #[Route('/update/{id<\d+>}/{name}/{firstname}/{age}', name: 'update')]
    public function updatePersonne($name,$firstname,$age,Personne $personne=null,ManagerRegistry $doctrine): Response
    {
        if($personne){
            $manager=$doctrine->getManager();
            $personne->setName($name);
            $personne->setFirstname($firstname);
            $personne->setAge($age);
            $manager->persist($personne);
            $manager->flush();
            $this->addFlash('succes',"la personne a été mis à jour avec succés");
        }
        else{
            $this->addFlash('error',"la personne n'existe pas");
        }
        return $this->redirectToRoute("all");
    }

    #[Route('/age/{agemin}/{agemax}', name: 'age')]
      public function getPersonneParAge($agemin,$agemax,ManagerRegistry $doctrine): Response
    {
       $repository=$doctrine->getRepository(Personne::class);
       $personne=$repository->findByAgeInterval($agemin,$agemax);
        return $this->render("personne\personne.html.twig",['personnes'=>$personne]);
    }

    #[Route('/age/stat/{agemin}/{agemax}', name: 'stat')]
    public function getStatPersonne($agemin,$agemax,ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Personne::class);
        $stats=$repository->statByAgeInterval($agemin,$agemax);
        return $this->render("personne\stat.html.twig",[
            'stats'=>$stats[0],
            'agemin'=>$agemin,
            'agemax'=>$agemax]);
    }



}



