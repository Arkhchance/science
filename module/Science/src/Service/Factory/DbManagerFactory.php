<?php
namespace Science\Service\Factory;

use Interop\Container\ContainerInterface;
use Science\Service\DbManager;

/**
 * This is the factory class for DbManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class DbManagerFactory
{
    /**
     * This method creates the UserManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $config = $container->get('Config');
        $config = $config['science'];

        return new DbManager($entityManager,$config);
    }
}
