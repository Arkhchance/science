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
                'dir' => 'left',
                'id' => 'identity',
                'label' => 'Welcome '.$this->authService->getIdentity(),
                'link'  => $url('home')
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