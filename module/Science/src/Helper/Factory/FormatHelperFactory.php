<?php
namespace Science\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Science\Helper\FormatHelper;

/**
 * This is the factory for form view helper. Its purpose is to instantiate the
 * helper
 */
class FormatHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $viewHelperManager = $container->get('ViewHelperManager');
        $urlHelper = $viewHelperManager->get('url');

        return new FormatHelper($urlHelper);
    }
}
