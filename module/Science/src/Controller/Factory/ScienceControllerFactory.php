<?php
namespace Science\Controller\Factory;

use Science\Controller\ScienceController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Science\Service\DataManager; 

/**
 * This is the factory for ScienceController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ScienceControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $dataService = $container->get(DataManager::class);
        return new ScienceController($entityManager,$dataService);
    }
}
