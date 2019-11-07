<?php

namespace App\DataFixtures;


use App\Refs\Entity\Company;
use App\Refs\Entity\Position;
use App\Refs\Entity\Vacancy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    public $container;

    public function load(ObjectManager $manager)
    {
        $this->create();
    }

    private function create()
    {
        $doctrine = $this->container->get('doctrine')->getManager();
        $company1 = new Company();
        $company1->setName('mobimill');
        $company1->setDescription('mobimillmobimillmobimillvmobimillvmobimillvvvmobimillv');
        $doctrine->persist($company1);

        $company2 = new Company();
        $company2->setName('epam');
        $company2->setDescription('epamepammobimillmobimillmobimillvmobimillvmobimillvvvmobimillv');
        $doctrine->persist($company2);
        $doctrine->flush();

        $position1 = new Position();
        $position1->setName('php');
        $position1->setDescription('phpphpphpphpphpvvv');
        $doctrine->persist($position1);

        $position2 = new Position();
        $position2->setName('java');
        $position2->setDescription('javajavajavajavajavajava');
        $doctrine->persist($position2);
        $doctrine->flush();

        $vacancy = new Vacancy();
        $vacancy->setCompany($company1);
        $vacancy->setPosition($position1);
        $vacancy->setSalary(2500);
        $vacancy->setHot(FALSE);
        $vacancy->setActive(TRUE);

        $doctrine->persist($vacancy);

        $vacancy = new Vacancy();
        $vacancy->setCompany($company1);
        $vacancy->setPosition($position1);
        $vacancy->setSalary(3500);
        $vacancy->setHot(TRUE);
        $vacancy->setActive(TRUE);


        $vacancy = new Vacancy();
        $vacancy->setCompany($company2);
        $vacancy->setPosition($position1);
        $vacancy->setSalary(3000);
        $vacancy->setHot(TRUE);
        $vacancy->setActive(TRUE);


        $vacancy = new Vacancy();
        $vacancy->setCompany($company1);
        $vacancy->setPosition($position2);
        $vacancy->setSalary(2000);
        $vacancy->setHot(TRUE);
        $vacancy->setActive(TRUE);


        $vacancy = new Vacancy();
        $vacancy->setCompany($company2);
        $vacancy->setPosition($position2);
        $vacancy->setSalary(4000);
        $vacancy->setHot(TRUE);
        $vacancy->setActive(TRUE);

        $doctrine->persist($vacancy);



        $doctrine->flush();
    }

    /**
     * Sets the container.
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = NULL)
    {
        $this->container = $container;
    }
}
