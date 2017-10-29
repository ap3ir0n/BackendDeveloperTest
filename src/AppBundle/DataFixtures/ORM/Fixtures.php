<?php
/**
 * Created by PhpStorm.
 * User: PatrickLuca
 * Date: 28/10/2017
 * Time: 22:50
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Grade;
use AppBundle\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class Fixtures extends Fixture
{
    /**
     * @var Generator
     */
    private $faker;

    /**
     * Fixtures constructor.
     */
    public function __construct()
    {
        // TODO: trasformare il faker in un servizio

        $this->faker = Factory::create();
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Dividere la creazione di studenti e voti in due file diversi

        for ($studentIndex = 0; $studentIndex < 3; $studentIndex++) {
            $student = new Student();
            $student->setName($this->faker->name());
            $student->setSurname($this->faker->lastName());
            $student->setEmail($this->faker->email());
            $manager->persist($student);
            for ($gradeIndex = 0; $gradeIndex < 2; $gradeIndex++) {
                $grade = new Grade();
                $grade->setStudent($student);
                $grade->setValue($this->faker->numberBetween(0, 10));
                $grade->setDescription($this->faker->sentence(3, true));
                $manager->persist($grade);
            }
        }
        $manager->flush();
    }
}