<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class ToDoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(SessionInterface $session, Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('todos')) {
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
        }

        return $this->render('to_do/listeToDo.html.twig');
    }

    #[Route('/add/{key?mardi}/{todo?sf6}', name: 'addtodo')]
    public function addtodo(SessionInterface $session, Request $request, $key, $todo): Response
    {
        $session = $request->getSession();
        if (!$session->has('todos')) {
            $session->getFlashBag()->add('initialisation', "la liste n'est pas encore initialisé");
        } else {
            $todos = $session->get('todos');
            if (isset($todos[$key])) {
                $session->getFlashBag()->add('keytrouvé', "le todo $key existe déja");
            } else {
                $todos[$key] = $todo;
                $session->set('todos', $todos);
                $session->getFlashBag()->add('success', "le todo $key a été ajouté avec succcés");

            }
        }

        return $this->redirectToRoute('todo');
    }

    #[Route('/update/{key}/{todo}', name: 'updatetodo')]
    public function updatetodo(Request $request, $key, $todo): Response
    {
        $session = $request->getSession();
        if (!$session->has('todos')) {
            $session->getFlashBag()->add('initialisation', "la liste n'est pas encore initialisé");
        } else {
            $todos = $session->get('todos');
            if (isset($todos[$key])) {
                $todos[$key]=$todo;
                $session->set('todos',$todos);
                $session->getFlashBag()->add('updatesuccess', "le todo $key est mis à jour avec succés");
            } else {
                $session->getFlashBag()->add('erreur', "le todo $key n'existe pas");
            }
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/delete/{key}', name: 'deletetodo')]
    public function deletetodo(Request $request, $key): Response
    {
        $session = $request->getSession();
        if (!$session->has('todos')) {
            $session->getFlashBag()->add('initialisation', "la liste n'est pas encore initialisé");
        } else {
            $todos = $session->get('todos');
            if (isset($todos[$key])) {
                unset($todos[$key]);
                $session->set('todos',$todos);
                $session->getFlashBag()->add('deletesuccess', "le todo $key est supprimé avec succés");
            } else {
                $session->getFlashBag()->add('erreur', "le todo $key n'existe pas");
            }
        }
        return $this->redirectToRoute('todo');
    }
}