<?php
namespace Science\Helper;

use Zend\View\Helper\AbstractHelper;


class FormatHelper extends AbstractHelper
{
    private $color1 = 'rgb(77, 121, 255)';
    private $color2 = 'rgb(115, 230, 0)';
    private $urlHelper;

    public function __construct($urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    public function getRandomColor()
    {
        $r = rand(0,255);
        $g = rand(0,255);
        $b = rand(0,255);

        return [$r,$g,$b];
    }

    public function format($number,$trailing = 0)
    {
        return number_format($number, $trailing, ',', ' ');
    }

    public function displayVulga($vulgas)
    {
        $cpt = 0;
        $result = "";

        foreach ($vulgas as $vulga) {
            if($cpt%2 == 0)
                $curcolor = $this->color1;
            else
                $curcolor = $this->color2;

            $result .= '<span style="color:'.$curcolor.';">';
            $result .= htmlspecialchars($vulga->getNom());
            $result .= '</span> ';

            $cpt++;
        }
        return $result;
    }

    public function timeConverter($time)
    {
        /*
        * 60 min = 1 hour
        * 1440 min = 1 day
        * 10 080 min = 1 week
        * 43 200 min = 1 month
        * 525 600 min = 1 year
        * 5 256 000 min = 10 year
        * 52 560 000 min = 100 year
        * 525 600 000 min = 1000 year
        */

        $unit = "minutes";
        if(intdiv($time,525600000) > 1) {
            $unit = intdiv($time,525600000) >= 2 ? "millénaires" : "millénaire";
            return $this->format($time/525600000,3)." $unit";
        } elseif(intdiv($time,52560000) > 1) {
            $unit = intdiv($time,52560000) >= 2 ? "siècles" : "siècle";
            return $this->format($time/52560000,3)." $unit";
        } elseif(intdiv($time,5256000) > 1) {
            $unit = intdiv($time,5256000) > 1 ? "décenies" : "décenie";
            return $this->format($time/5256000,3)." $unit";
        } elseif(intdiv($time,525600) >= 2) {
            $unit = "années";
            return $this->format($time/525600,3)." $unit";
        } elseif(intdiv($time,43200) >= 2) {
            $unit = "mois";
            return $this->format($time/43200,2)." $unit";
        } elseif(intdiv($time,10080) >= 2) {
            $unit = "semaines";
            return $this->format($time/10080,2)." $unit";
        } elseif(intdiv($time,1440) >= 2) {
            $unit = "jours";
            return $this->format($time/1440,2)." $unit";
        } elseif(intdiv($time,60) >= 2) {
            $unit = "heures";
            return $this->format($time/60,0)." $unit";
        } else {
            return $this->format($time,0)." $unit";
        }
    }
}
