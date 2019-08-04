<?php
namespace Science\Service;

class DataManager
{

    private $data;
    private $lock = false;
    /**
     * Constructs
     */
    public function __construct()
    {
        $this->data['label']   = "";
        $this->data['abo']     = 0;
        $this->data['vid']     = 0;
        $this->data['vue']     = 0;
        $this->data['like']    = 0;
        $this->data['dislike'] = 0;
        $this->data['minutes'] = 0;
        $this->data['watch']   = 0;
        $this->data['min_v']   = 0;
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

    public function computeData($people = 1)
    {
        //execute only once
        if($this->lock)
            return;

        if($people < 1)
            $people = 1;

        if($this->data['dislike']!=0)
            $this->data['likeDis'] = $this->data['like'] / $this->data['dislike'];
        else
            $this->data['likeDis'] = 0;
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

        //compute average
        $this->data['abo']     /= $people;
        $this->data['vid']     /= $people;
        $this->data['vue']     /= $people;
        $this->data['like']    /= $people;
        $this->data['dislike'] /= $people;
        $this->data['minutes'] /= $people;
        $this->data['watch']   /= $people;


        //convert to hour
        $this->data['minutes'] /= 60;
        //convert to day
        $this->data['watch'] /= (60*24);

        //do not reexecute
        $this->lock = true;
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
