<?php
namespace Science\Controller\Factory;

use Science\Controller\ScienceController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for ScienceController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ScienceControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        return new ScienceController();
    }
}
