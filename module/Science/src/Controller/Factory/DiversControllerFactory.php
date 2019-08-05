<?php
namespace Science\Controller\Factory;

use Science\Controller\DiversController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Science\Service\ContactManager;


/**
 * This is the factory for DiversController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class DiversControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $contactService = $container->get(ContactManager::class);
        return new DiversController($entityManager,$contactService);
    }
}
