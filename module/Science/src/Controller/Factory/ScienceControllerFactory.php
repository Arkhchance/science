<?php
namespace Science\Controller\Factory;

use Science\Controller\ScienceController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Science\Service\StatsManager;
use Science\Service\ConstructGraphManager;

/**
 * This is the factory for ScienceController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ScienceControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $statsService = $container->get(StatsManager::class);
        $graphService = $container->get(ConstructGraphManager::class);

        return new ScienceController($entityManager,$statsService,$graphService);
    }
}
