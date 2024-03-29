<?php
namespace Science;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'science' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/science[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ScienceController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'divers' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/divers[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\DiversController::class,
                        'action'     => 'apropos',
                    ],
                ],
            ],
            'vulgarisateurs' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/vulgarisateurs[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\VulgaController::class,
                        'action'     => 'display',
                    ],
                ],
            ],
            'manage' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/manage[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'   =>  '[0-9]*',

                    ],
                    'defaults' => [
                        'controller' => Controller\ManageController::class,
                        'action'     => 'add',
                    ],
                ],
            ],
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'register' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/register',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'register',
                    ],
                ],
            ],
            'reset-password' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/reset-password',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'resetPassword',
                    ],
                ],
            ],
            'set-password' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/set-password',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'setPassword',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class    => Controller\Factory\AuthControllerFactory::class,
            Controller\ScienceController::class => Controller\Factory\ScienceControllerFactory::class,
            Controller\ManageController::class  => Controller\Factory\ManageControllerFactory::class,
            Controller\DiversController::class  => Controller\Factory\DiversControllerFactory::class,
            Controller\VulgaController::class  => Controller\Factory\VulgaControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
            Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
            Service\AuthManager::class => Service\Factory\AuthManagerFactory::class,
            Service\UserManager::class => Service\Factory\UserManagerFactory::class,
            Service\DbManager::class   => Service\Factory\DbManagerFactory::class,
            Service\ApiManager::class  => Service\Factory\ApiManagerFactory::class,
            Service\ContactManager::class => Service\Factory\ContactManagerFactory::class,
            Service\YoutubeManager::class => Service\Factory\YoutubeManagerFactory::class,
            Service\StatsManager::class   => Service\Factory\StatsManagerFactory::class,
            Service\ConstructGraphManager::class => Service\Factory\ConstructGraphManagerFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            Helper\FormDisplay::class => Helper\Factory\FormDisplayFactory::class,
            Helper\FormatHelper::class => Helper\Factory\FormatHelperFactory::class,
        ],
        'aliases' => [
            'formDisplay' => Helper\FormDisplay::class,
            'formatData' => Helper\FormatHelper::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
        'strategies' => array('ViewJsonStrategy',),
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'access_filter' => [
        'options' => [
            // The access filter can work in 'restrictive' (recommended) or 'permissive'
            // mode. In restrictive mode all controller actions must be explicitly listed
            // under the 'access_filter' config key, and access is denied to any not listed
            // action for not logged in users. In permissive mode, if an action is not listed
            // under the 'access_filter' key, access to it is permitted to anyone (even for
            // not logged in users. Restrictive mode is more secure and recommended to use.
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\AuthController::class => [
                // this class is always allow
            ],
            Controller\ScienceController::class => [
                // * = allow  @ = auth user only
                [
                    'actions' => [
                        'index','getform','graphperso','graphs','catgraph',
                        'stats','vulgastats','domainestats','domaine'
                    ],
                'allow' => '*'
                ],
            ],
            Controller\ManageController::class => [
                // * = allow  @ = auth user only
                ['actions' => ['add'], 'allow' => '@'],
            ],
            Controller\DiversController::class => [
                // * = allow  @ = auth user only
                ['actions' => ['apropos','erreur'], 'allow' => '*'],
            ],
            Controller\VulgaController::class => [
                // * = allow  @ = auth user only
                ['actions' => ['details','display'], 'allow' => '*'],
            ],
        ]
    ],
];
