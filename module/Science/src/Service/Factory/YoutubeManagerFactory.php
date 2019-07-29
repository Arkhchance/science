<?php
namespace Science\Service\Factory;

use Interop\Container\ContainerInterface;
use Science\Service\YoutubeManager;

/**
 * This is the factory class for youtubeManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class YoutubeManagerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $config = $container->get('Config');
        $config = $config['science']['api'];
        return new YoutubeManager($entityManager,$config);
    }
}
