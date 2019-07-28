<?php
namespace Science\Helper;

use Zend\View\Helper\AbstractHelper;
use Science\Entity\Langue;
use Science\Entity\Pays;
use Science\Entity\Domaine;
use Science\Entity\Plateforme;

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

    public function renderPlateforme()
    {
        $pfs = $this->entityManager->getRepository(Plateforme::class)->findAll();

        $result  = '<table class="table table-striped table-dark table-bordered">';
        $result .= <<<EOF
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nom</th>
                      <th scope="col">Adresse</th>
                      <th scope="col">Post name</th>
                      <th scope="col">Regex</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
EOF;
        $result .= '<tbody>';

        foreach ($pfs as $pf) {
            $result .= '<tr>';
            $result .= '<th scope="row">'.$pf->getId().'</th>';
            $result .= '<td>'.$pf->getNom().'</td>';
            $result .= '<td>'.$pf->getAddress().'</td>';
            $result .= '<td>'.$pf->getPostName().'</td>';
            $result .= '<td>'.$pf->getIdExtractPattern().'</td>';
            $result .= '<td><a href="/manage/plateforme/'.$pf->getId().'">edit</a></td>';
            $result .= '<td><button type="button" dval="'.$pf->getId().'" class="Pdelete btn btn-danger btn-sm">delete</button></td>';
            $result .= '</tr>';
        }

        $result .= '</tbody>';
        $result .= '</table>';

        return $result;
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
