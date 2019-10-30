<?php

namespace App\Rabbit;

use App\Entity\Message;
use App\Repository\MessageRepository;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EmailService implements ConsumerInterface, ContainerAwareInterface
{
    public $container;

    public function execute(AMQPMessage $msg)
    {
        $response = json_decode($msg->body, TRUE);

        $type = $response["Type"];

        if ($type == "Message") {
            $this->sendVerificationEmail($response);
        }
    }

    private function sendVerificationEmail($response)
    {
//        $doctrine = $registry->getManager();
        $message = new Message();
        $message->setTitle($response['title']);
        $message->setDescription($response['description']);

//        $doctrine->persist($message);
//        $doctrine->flush();
        print_r($message);
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