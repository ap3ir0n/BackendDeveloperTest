<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Event\GradesUpdatedEvent;
use AppBundle\Form\StudentGradesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Student controller.
 *
 * @Route("student")
 */
class StudentController extends Controller
{
    /**
     * Lists all student entities.
     *
     * @Route("/", name="student_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository('AppBundle:Student')->findAll();

        return $this->render('student/index.html.twig', array(
            'students' => $students,
        ));
    }

    /**
     * Displays a form to edit an existing student entity.
     *
     * @Route("/{id}/grades/edit", name="student_grades_edit")
     * @Method({"GET", "POST"})
     */
    public function editGradesAction(Request $request, Student $student)
    {
        $form = $this->createForm(StudentGradesType::class, $student);
        $form->handleRequest($request);

        $test = $this->get('validator')->validate($student);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $event = new GradesUpdatedEvent($student);
            $this->get('event_dispatcher')->dispatch($event::NAME, $event);

            return $this->redirectToRoute('student_grades_edit', array('id' => $student->getId()));
        }

        return $this->render('student/grades_edit.html.twig', array(
            'student' => $student,
            'form' => $form->createView(),
        ));
    }

}
