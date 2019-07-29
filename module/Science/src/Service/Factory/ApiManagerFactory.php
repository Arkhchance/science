<?php
namespace Science\Service\Factory;

use Interop\Container\ContainerInterface;
use Science\Service\ApiManager;
use Science\Service\YoutubeManager;


/**
 * This is the factory class for ApiManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class ApiManagerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $youtubeService = $container->get(YoutubeManager::class);
        return new ApiManager($entityManager,$youtubeService);
    }
}
