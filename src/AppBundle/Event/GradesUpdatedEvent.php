<?php
/**
 * Created by PhpStorm.
 * User: PatrickLuca
 * Date: 29/10/2017
 * Time: 15:40
 */

namespace AppBundle\Event;


use AppBundle\Entity\Student;
use Symfony\Component\EventDispatcher\Event;

class GradesUpdatedEvent extends Event
{
    const NAME = 'grades.updated';

    /**
     * @var Student
     */
    protected $student;

    /**
     * GradesUpdated constructor.
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

}