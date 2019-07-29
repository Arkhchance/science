<?php
namespace Science\Controller\Factory;

use Science\Controller\ManageController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Science\Service\DbManager;
use Science\Service\ApiManager;
/**
 * This is the factory for ScienceController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ManageControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbManager = $container->get(DbManager::class);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $apiService = $container->get(ApiManager::class);
        return new ManageController($dbManager,$entityManager,$apiService);
    }
}
