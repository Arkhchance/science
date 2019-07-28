<?php
namespace Science\Helper;

use Zend\View\Helper\AbstractHelper;
use Science\Entity\Langue;
use Science\Entity\Pays;
use Science\Entity\Domaine;

/**
 * This view helper class displays select multiples
 */
class FormDisplay extends AbstractHelper
{
    /**
     * doctrine service.
     * @var array
     */
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function renderLangue()
    {
        $langues = $this->entityManager->getRepository(Langue::class)->findAll();

        $result = '<select id="iselect" class="manageselect bg-transparent" name="langue[]" multiple>';

        foreach ($langues as $langue) {
            $result .= '<option value="'.$langue->getId().'">';
            $result .= $langue->getDrapeau();
            $result .= ' => '.$langue->getNom();

            $result .= ' => '.$langue->getCode();
            $result .= '</option>';
        }

        $result .= '</select>';

        return $result;
    }

    public function renderPays()
    {
        $payss = $this->entityManager->getRepository(Pays::class)->findAll();

        $result = '<select id="iselect" class="manageselect bg-transparent" name="pays[]" multiple>';

        foreach ($payss as $pays) {
            $result .= '<option value="'.$pays->getId().'">';
            $result .= $pays->getDrapeau();
            $result .= ' => '.$pays->getNom();

            $result .= ' => '.$pays->getCode();
            $result .= '</option>';
        }

        $result .= '</select>';

        return $result;
    }

    public function renderDomaine()
    {
        $domaines = $this->entityManager->getRepository(Domaine::class)->findAll();

        $result = '<select id="iselect" class="manageselect bg-transparent" name="pays[]" multiple>';

        foreach ($domaines as $domaine) {
            $result .= '<option value="'.$domaine->getId().'">';
            $result .= $domaine->getNom();
            $result .= ' => '.$domaine->getDescription();

            $result .= '</option>';
        }

        $result .= '</select>';

        return $result;
    }
}
