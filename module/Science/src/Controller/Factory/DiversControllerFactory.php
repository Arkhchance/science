<?php
namespace Science\Controller\Factory;

use Science\Controller\DiversController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface; 

/**
 * This is the factory for DiversController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class DiversControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new DiversController($entityManager);
    }
}
