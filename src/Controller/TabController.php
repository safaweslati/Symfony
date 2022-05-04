<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tableau', name: 'tab')]
    public function tab(){
        $notes=[902,527,65,215,815,802,80];
        return($this->render('tab\note.html.twig' , [
            'notes'=>$notes,
            'path'=>'    '
        ]));
    }
    #[Route('/users', name: 'users')]
    public function users(){
        $users=[
            ['name'=>'safa',
                'firstname'=>'oueslati',
                'age'=>21
            ],
            ['name'=>'ahmed',
            'firstname'=>'oueslati',
            'age'=>25
        ],
        ['name'=>'sarah',
                'firstname'=>'oueslati',
                'age'=>34
            ]
        ];
       return $this->render('tab\index.html.twig',[
          'users'=>$users
       ]);

    }


}
