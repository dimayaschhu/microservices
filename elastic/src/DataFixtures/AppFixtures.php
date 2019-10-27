<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    public $container;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
                dump('AppFixtures', $i);

            $this->create();
        }
    }

    private function create()
    {
        $doctrine = $this->container->get('doctrine')->getManager();
        for ($i = 0; $i < 100; $i++) {
            $product = new Company();
            $product->setName(md5(rand(0, 10000)));
            $product->setNumber(rand(0, 10000));
            $product->setPrice(rand(0, 10000));
            $doctrine->persist($product);
        }
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
