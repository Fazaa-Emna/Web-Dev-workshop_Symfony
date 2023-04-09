<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomFormType;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/classroom/list', name: 'classroom_list')]
    public function list(ClassroomRepository $classroomRepo): Response
    {
        $classrooms = $classroomRepo->findAll();
        return $this->render('classroom/list.html.twig', [
            'classrooms' => $classrooms,
        ]);
    }

    #[Route('/classroom/addClass', name: 'addClassroom')]
    public function addClass(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomFormType::class, $classroom);
        $form->add('Add', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classroom);
            $entityManager->flush();

            return $this->redirectToRoute('classroom_list');
        }

        return $this->render('classroom/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/classroom/{id}/update', name: 'modifyClassroom')]
    public function modifyClass(Request $request, ClassroomRepository $classroomRepo, $id, Classroom $classroom, EntityManagerInterface $entityManager): Response
    {
        $classroom = $classroomRepo->find($id);
        //form creation
        $form = $this->createForm(ClassroomFormType::class, $classroom);
        $form->add('Update', SubmitType::class);
        //request handeling
        $form->handleRequest($request);
        //send data to database if any data is submitted
        if ($form->isSubmitted()) {
            $entityManager->flush();
            //return $this->redirectToRoute('showOneC',['id'=>$classroom->getId()]);
            return $this->redirectToRoute('classroom_list');
        }

        return $this->render('classroom/add.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/classroom/{id}/delete', name: 'deleteClassroom')]
    public function deleteClass(ClassroomRepository $classroomRepo, $id, Classroom $classroom, EntityManagerInterface $entityManager): Response
    {
        $classroom = $classroomRepo->find($id);
        $entityManager->remove($classroom);
        $entityManager->flush();
        return $this->redirectToRoute('classroom_list');
    }
}
