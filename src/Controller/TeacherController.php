<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    #[Route('/showTeacher/{name}', name: 'show_teacher')]
    public function showTeacher($name): Response
    {
        return $this->render('teacher/showteacher.html.twig', [
            'name' => $name,
        ]);
    }
    #[Route('/showStudent', name: 'show_teacher')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_student');
    }
}
