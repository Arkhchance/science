<?php
namespace Science\Helper;

use Zend\View\Helper\AbstractHelper;
use Science\Entity\Langue;

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

}
