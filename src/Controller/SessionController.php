<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        $session=$request->getSession();
        if(!$session->has('nbvisite'))
        {
            $nbreVisite=1;
            $session->set('nbvisite',$nbreVisite);
        }
        else{
            $nbreVisite=$session->get('nbvisite');
            $nbreVisite=$nbreVisite+1;
            $session->set('nbvisite',$nbreVisite);
        }
        return $this->render('session/index.html.twig');
    }
}
