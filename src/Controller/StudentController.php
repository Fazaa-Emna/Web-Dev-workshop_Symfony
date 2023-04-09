<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\StudentRepository;
use App\Form\StudentFormType;
use Doctrine\DBAL\Driver\OCI8\Exception\Error;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): 
    {
        //return new Response('Hello my students');
        return new Error('Hello my students');
    }

    #[Route('/student/add', name: 'studentAdd')]
    public function addStudent(Request $request, EntityManagerInterface $entityManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentFormType::class, $student);
        $form->add('Add', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('studentList');
        }

        return $this->render('student/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/student/list', name: 'studentList')]
    public function list(StudentRepository $studentRepo): Response
    {
        $students = $studentRepo->findAll();
        return $this->render('student/list.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/student/{id}/delete', name: 'deleteStudent')]
    public function delete(StudentRepository $studentRepo, $id, Student $student, EntityManagerInterface $entityManager): Response
    {
        $student = $studentRepo->find($id);
        $entityManager->remove($student);
        $entityManager->flush();
        return $this->redirectToRoute('studentList');
    }

    #[Route('/student/{id}/update', name: 'modifyStudent')]
    public function modify(Request $request, StudentRepository $studentRepo, $id, Student $student, EntityManagerInterface $entityManager): Response
    {
        $student = $studentRepo->find($id);
        //form creation
        $form = $this->createForm(StudentFormType::class, $student);
        $form->add('Update', SubmitType::class);
        //request handeling
        $form->handleRequest($request);
        //send data to database if any data is submitted
        if ($form->isSubmitted()) {
            $entityManager->flush();
            //return $this->redirectToRoute('showOneC',['id'=>$classroom->getId()]);
            return $this->redirectToRoute('studentList');
        }

        return $this->render('student/add.html.twig', [
            'form' => $form,
        ]);
    }
}