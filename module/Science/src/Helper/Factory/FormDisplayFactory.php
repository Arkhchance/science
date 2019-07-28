<?php
namespace Science\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Science\Helper\FormDisplay;

/**
 * This is the factory for form view helper. Its purpose is to instantiate the
 * helper
 */
class FormDisplayFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new FormDisplay($entityManager);
    }
}
