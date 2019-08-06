<?php
namespace Science\Controller\Factory;

use Science\Controller\VulgaController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Science\Service\ContactManager;
/**
 * This is the factory for VulgaController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class VulgaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $contactService = $container->get(ContactManager::class);
        return new VulgaController($entityManager,$contactService);
    }
}
