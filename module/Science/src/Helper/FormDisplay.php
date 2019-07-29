<?php
namespace Science\Helper;

use Zend\View\Helper\AbstractHelper;
use Science\Entity\Langue;
use Science\Entity\Pays;
use Science\Entity\Domaine;
use Science\Entity\Plateforme;
use Science\Entity\Vulga;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class FormDisplay extends AbstractHelper
{
    /**
     * doctrine service.
     * @var array
     */
    protected $entityManager;

    public $pagiVulga;
    public $pagiLink;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function renderState($vulga)
    {
        $public = $vulga->getPrivateStatusAsString() == "Public" ? true : false;
        $check1 = $public ? "" : "checked";
        $check2 = $public ? "checked" : "" ;

        $result  = '<span class="group">';
        $result .= '<input type="radio" class="private" name="st'.$vulga->getId().'" id="u'.$vulga->getId().'" '.$check1.'>';
        $result .= '<label for="u'.$vulga->getId().'">Privé</label>';
        $result .= '<input type="radio" class="public" name="st'.$vulga->getId().'" id="p'.$vulga->getId().'" '.$check2.'>';
        $result .= '<label for="p'.$vulga->getId().'">Public</label>';
        $result .= '</span>';

        return $result;
    }
    public function renderLink($page = 1)
    {
        $vulgas = $this->entityManager->getRepository(Vulga::class)->findVulga();

        $adapter = new DoctrineAdapter(new ORMPaginator($vulgas, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(9);
        $paginator->setCurrentPageNumber($page);
        $this->pagiLink = $paginator;

        $result  = '<table class="table table-striped table-bordered">';
        $result .= <<<EOF
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nom</th>
                      <th scope="col">Plateforme</th>
                    </tr>
                  </thead>
EOF;
        $result .= '<tbody>';

        foreach ($paginator as $vulga) {
            $result .= '<tr>';
            $result .= '<th scope="row">'.$vulga->getId().'</th>';
            $result .= '<td>'.$vulga->getNom().'</td>';
            $result .= '<td>';
            foreach ($vulga->getPlateforme() as $pf) {
                $result .= '<div class="row"><div class="col">';
                $result .= $pf->getNom()."</div>";
                $result .= '<div class="col"><button type="button" vulgaid="'.$vulga->getId().'" pfid="'.$pf->getId().'" class="Ldelete btn btn-danger btn-sm">delete</button></div>';
                $result .= '</div>';
            }
            $result .= '</td>';
            $result .= '</tr>';
        }

        $result .= '</tbody>';
        $result .= '</table>';

        return $result;
    }
    public function renderVulga($page = 1)
    {
        $vulgas = $this->entityManager->getRepository(Vulga::class)->findVulga();

        $adapter = new DoctrineAdapter(new ORMPaginator($vulgas, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(9);
        $paginator->setCurrentPageNumber($page);
        $this->pagiVulga = $paginator;

        $result  = '<table class="table table-striped table-bordered">';
        $result .= <<<EOF
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nom</th>
                      <th scope="col">Sexe</th>
                      <th scope="col">Langue</th>
                      <th scope="col">Pays</th>
                      <th scope="col">Domaine</th>
                      <th scope="col">Plateforme</th>
                      <th scope="col">Privé/Public</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
EOF;
        $result .= '<tbody>';

        foreach ($paginator as $vulga) {
            $result .= '<tr>';
            $result .= '<th scope="row">'.$vulga->getId().'</th>';
            $result .= '<td>'.$vulga->getNom().'</td>';
            $result .= '<td>'.$vulga->getSexeAsString().'</td>';
            $result .= '<td>'.$vulga->getLangue()->getDrapeau().'</td>';
            $result .= '<td>'.$vulga->getPays()->getDrapeau().'</td>';
            $result .= '<td>';
            foreach ($vulga->getDomaine() as $domaine) {
                $result .= '<div data-toggle="tooltip" data-placement="left" title="'.$domaine->getDescription().'">';
                $result .= $domaine->getNom()."</div>";
            }
            $result .= '</td>';
            $result .= '<td>';
            foreach ($vulga->getPlateforme() as $pf) {
                $result .= $pf->getNom()."<br>";
            }
            $result .= '</td>';
            $result .= '<td>'.$this->renderState($vulga).'</td>';
            $result .= '<td><a href="/manage/vulga/'.$vulga->getId().'">edit</a></td>';
            $result .= '<td><button type="button" dtype="vulga" dval="'.$vulga->getId().'" class="Pdelete btn btn-danger btn-sm">delete</button></td>';
            $result .= '</tr>';
        }

        $result .= '</tbody>';
        $result .= '</table>';

        return $result;
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
            $result .= '<td><button type="button" dtype="plateforme" dval="'.$pf->getId().'" class="Pdelete btn btn-danger btn-sm">delete</button></td>';
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
