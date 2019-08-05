<?php
namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;

    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper)
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];

        $items[] = [
            'dir' => 'left',
            'id' => 'identity',
            'label' => 'Home',
            'link'  => $url('home')
        ];
        $items[] = [
            'dir' => 'dropdown',
            'id' => 'dropdown',
            'label' => 'Stats',
            'items' => [
                [
                    'label' => 'Stats global',
                    'link'  => $url('science',['action'=>'stats']),
                ],
                [
                    'label' => 'Stats par vulgarisateur',
                    'link'  => $url('science',['action'=>'vulgastats']),
                ],
                [
                    'label' => 'Stats par catégorie',
                    'link'  => $url('science',['action'=>'domainestats']),
                ]
            ]
        ];
        $items[] = [
            'dir' => 'dropdown',
            'id' => 'dropdown',
            'label' => 'Graphs',
            'items' => [
                [
                    'label' => 'Graphs par vulgarisateur',
                    'link'  => $url('science',['action'=>'graphs']),
                ],
                [
                    'label' => 'Graphs par catégorie',
                    'link'  => $url('science',['action'=>'catgraph']),
                ],
                [
                    'label' => 'Graphs personalisé',
                    'link'  => $url('science',['action'=>'graphperso']),
                ]
            ]
        ];
        $items[] = [
            'dir' => 'left',
            'id' => 'about',
            'label' => 'A propos',
            'link'  => $url('divers',['action'=>'apropos'])
        ];
        $items[] = [
            'dir' => 'left',
            'id' => 'erreur',
            'label' => 'contact',
            'link'  => $url('divers',['action'=>'erreur'])
        ];
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'dir' => 'right',
                'id' => 'login',
                'label' => 'Login',
                'link'  => $url('login')
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'register',
                'label' => 'Register',
                'link'  => $url('register')
            ];

        } else {
            $items[] = [
                'dir' => 'right',
                'id' => 'msg',
                'label' => 'Messages',
                'link'  => $url('manage',['action'=>'message'])
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'Langue',
                'label' => 'Langue',
                'link'  => $url('manage',['action'=>'langue'])
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'Pays',
                'label' => 'Pays',
                'link'  => $url('manage',['action'=>'pays'])
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'Domaine',
                'label' => 'Domaine',
                'link'  => $url('manage',['action'=>'domaine'])
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'Plateforme',
                'label' => 'Plateforme',
                'link'  => $url('manage',['action'=>'plateforme'])
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'Vulgarisateur',
                'label' => 'Vulgarisateur',
                'link'  => $url('manage',['action'=>'vulga'])
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'Link',
                'label' => 'Link',
                'link'  => $url('manage',['action'=>'link'])
            ];
            $items[] = [
                'dir' => 'right',
                'id' => 'logout',
                'label' => 'Logout',
                'link'  => $url('logout')
            ];
        }

        return $items;
    }
}
