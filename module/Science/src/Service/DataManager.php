<?php
namespace Science\Service;

class DataManager
{

    private $data;

    /**
     * Constructs
     */
    public function __construct()
    {
        $this->data['label']   = "";
        $this->data['id']      = 0;
        $this->data['nom']     = "";
        $this->data['min_v']   = 0;
        $this->data['abo']     = 0;
        $this->data['vid']     = 0;
        $this->data['vue']     = 0;
        $this->data['like']    = 0;
        $this->data['dislike'] = 0;
        $this->data['minutes'] = 0;
        $this->data['watch']   = 0;
    }

    public function addData($data)
    {
        $this->data['abo']     += $data['abo'] ;
        $this->data['vid']     += $data['vid'] ;
        $this->data['vue']     += $data['vue'] ;
        $this->data['like']    += $data['like'] ;
        $this->data['dislike'] += $data['dislike'] ;
        $this->data['minutes'] += $data['minutes'] ;
        $this->data['watch']   += $data['watch'] ;
    }

    public function computeData()
    {
        if($this->data['vid']!=0) {
            $this->data['like_v']  = $this->data['like'] / $this->data['vid'];
            $this->data['dis_v']   = $this->data['dislike'] / $this->data['vid'];
            $this->data['min_v']   = $this->data['minutes'] / $this->data['vid'];
            $this->data['vue_v']   = $this->data['vue'] / $this->data['vid'];
        } else {
            $this->data['like_v'] = 0;
            $this->data['dis_v']  = 0;
            $this->data['min_v']  = 0;
            $this->data['vue_v']  = 0;
        }
        if($this->data['dislike']!=0)
            $this->data['likeDis'] = $this->data['like'] / $this->data['dislike'];
        else
            $this->data['likeDis'] = 0;

    }

    public function getData()
    {
        return $this->data;
    }

    public function setLabel($label)
    {
        $this->data['label'] = $label;
    }
}
