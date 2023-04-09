<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig');
    }
    #[Route('/club/get/{name}', name: 'getname')]
    public function getName($name): Response
    {
        return $this->render('club/detail.html.twig',[
            "name" => $name,
        ]);
    }
    #[Route('/list', name: 'lista')]
    public function list(): Response
    {
        $courses = array(
            array('ref' => 'form147', 'Title' => 'Formation Symfony 4', 'Description' => 'practical training', 'start_date' => '12/06/2020', 'end_date' => '19/06/2020', 'nb_participants' => 19),

            array('ref' => 'form177', 'Title' => 'Formation SOA', 'Description' => 'theoretical training', 'start_date' => '03/12/2020', 'end_date' => '10/12/2020', 'nb_participants' => 0),

            array('ref' => 'form178', 'Title' => 'Formation Angular', 'Description' => 'theoretical training', 'start_date' => '10/06/2020', 'end_date' => '14/06/2020', 'nb_participants' => 12)

        );
        return $this->render('club/list.html.twig',[
            "courses" => $courses,
        ]);
    }
}
