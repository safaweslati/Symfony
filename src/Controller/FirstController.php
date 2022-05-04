<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'first')]
    public function first(): Response
    {
        $reponse=new Response('<h1>Hello Forma</h1>');
        return $reponse;
    }
    #[Route('/first/{nom}', name: 'first2')]
    public function firstnom($nom): Response
    {
        $reponse=new Response("<h1>Bonjour $nom</h1>");
        return $reponse;
    }
    #[Route('/second', name: 'second')]
    public function second(Request $req): Response
    {
        $reponse=new Response();
        dd($req);
        dd($reponse);
        return $this->render('first\second.html.twig',
            ["reponse"=>$reponse,"request"=>$req]);
    }
    #[Route('/sayHello/{name}', name: 'hello')]
    public function hello($name): Response
    {
        $x=rand(0,10);
        if($x==2) {
            return $this->redirectToRoute('first');
        }
        else{
            return $this->forward(' App\Controller\FirstController::second');
            }
        
    }

    #[Route('/cv/{name}/{surname}/{age}/{section}', name: 'cv')]
    public function action($name,$surname,$age,$section,Request $request): Response
    {
        $request->request->set('lieu', 'tunis');
        dd($request);
        $lieu = $request->request->get('lieu');
        return $this->render("cv\cv.html.twig",
            [
                'nom' => $name,
                'prenom' => $surname,
                'age' => $age,
                'section' => $section,
                'lieu' => $lieu
            ]);
    }

    #[Route('/multi/{entier1<\d+>}/{entier2<\d+>}', name: 'multi')]
    public function multiplication($entier1,$entier2){
        $resultat=$entier1*$entier2;
        $response=new Response("<h1>$resultat</h1>");
        return($response);
    }

}
