<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class FinanceController implements ContainerAwareInterface
{
    public $container;
    /**
     * @Route("/create_message",methods={"POST"})
     */
    public function postCreateUser(Request $request)
    {

        $message = ["Type"      => "Message",
                    "title" => $request->get('title'),
                    "description"  => $request->get('description'),
        ];
        $rabbitMessage = json_encode($message);

        $this->container->get('old_sound_rabbit_mq.emailing_producer')->setContentType('application/json');
        $this->container->get('old_sound_rabbit_mq.emailing_producer')->publish($rabbitMessage);

        return new JsonResponse(['Status' => 'OK']);

    }

    /**
     * @Route("/consumer", name="consumer", methods={"GET"})
     */
    public function consumer()
    {
        dd('stop');

    }

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = NULL)
    {
        $this->container = $container;
    }
}
