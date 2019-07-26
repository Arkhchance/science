<?php
namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays login informatioon
 */
class Menu extends AbstractHelper
{
    /**
     * Menu items array.
     * @var array
     */
    protected $items = [];

    public function __construct($items=[])
    {
        $this->items = $items;
    }


    public function render()
    {
        $left = '';
        $right = '';

        foreach ($this->items as $item) {
            if($item['dir'] == 'left')
                $left .= $this->renderItemLeft($item);
             else
                $right .= $this->renderItemRight($item);
        }

        $result  = '<div class="collapse navbar-collapse" id="contentcollapse">';

        //left
        $result .= '<ul class="navbar-nav mr-auto">';
        $result .= $left;
        $result .= '</ul>';

        //search
        $result .= '<form class="form-inline" action="/search" method="post">';
        $result .= '<input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">';
        $result .= '</form>';

        //right
        $result .= '<ul class="nav navbar-nav navbar-right">';
        $result .= $right;
        $result .= '</ul>';

        $result .= '</div>';

        return $result;
    }

    protected function renderItemLeft($item)
    {
        $result = '<li class="nav-item">';
        $result .= '<a class="nav-link" href="'.$item['link'].'">'.$item['label'].'</a>';
        $result .= '</li>';
        return $result;
    }

    protected function renderItemRight($item)
    {
        $result = '<li class="nav-item">';
        $result .= '<a class="nav-link" href="'.$item['link'].'">'.$item['label'].'</a>';
        $result .= '</li>';
        return $result;
    }
}