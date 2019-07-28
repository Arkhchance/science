<?php
namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays login informatioon
 */
class SidePannel extends AbstractHelper
{

    protected $authService;

    public function __construct($authService)
    {
        $this->authService = $authService;
    }


    public function render()
    {
        if($this->authService->hasIdentity())
            return $this->renderLeftPannel();
        else
            return '';
    }

    protected function renderLeftPannel()
    {
        $leftpannel = <<< EOF

<nav id="sidebar" class="active">
   <div class="sidebar-header">
       <h3>Menu</h3>
   </div>
   <ul class="list-unstyled components">
       <p>Reglage</p>
       <li>
           <a href="/manage/langue">Langue</a>
       </li>
       <li>
           <a href="/manage/pays">Pays</a>
       </li>
       <li>
           <a href="/manage/domaine">Domaine</a>
       </li>
       <li>
           <a href="/manage/plateforme">Plateforme</a>
       </li>
       <li>
           <a href="/manage/vulga">Vulgarisateur</a>
       </li>
   </ul>
</nav>
EOF;
        return $leftpannel;
    }

}
