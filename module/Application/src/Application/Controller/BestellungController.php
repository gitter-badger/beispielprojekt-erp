<?php
namespace Application\Controller;

use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;

class BestellungController extends AbstractActionController
{

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * BestellungController constructor.
     * @param $serviceLocator ServiceLocatorInterface
     */
    public function __construct($serviceLocator) {

        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Diese Action dient dazu die Daten für eine Bestellung aufzunehmen
     * und den sntprechenden Prozess zu starten
     * @return array
     * @throws \Exception falls request weder GET noch POST ist
     */
    public function bestellenAction()
    {
        /* @var $request Request */
        $request = $this->getRequest();

        // GET Kontext liefert die Eingabemaske
        if($request->isGet()) {

            // Material Service benutzen
            /* @var $materialService \Application\Service\MaterialService */
            $materialService = $this->serviceLocator->get('Application\Service\Material');

            // Bestellbare Materialien laden
            $materialien = $materialService->getMaterialien();

            // Liste bestellbarer Materialien an View übergeben
            return array('materialien' => $materialien,
                         'success' => $this->params()->fromRoute('success', false));


        // POST Kontext verarbeitet die Bestellung
        } else if($request->isPost()) {

            // Bestellung Service benutzen
            /* @var $bestellungService \Application\Service\BestellungService */
            $bestellungService = $this->serviceLocator->get('Application\Service\Bestellung');

            // POST Parameter benutzen
            $postParams = $request->getPost()->toArray();

            // Bestellung ausführen
            $bestellungService->bestellen($postParams['bezeichnung'], $postParams['material'], $postParams['anzahl']);

            // Nach erfolgreichem bestellen, weiterleiten auf das leere Bestellformular
            $this->redirect()->toRoute('application/wildcard', array('controller' => 'Bestellung', 'action' => 'bestellen', 'success' => 'true'));
        }

        throw new \Exception("Es werden hier nur GET oder POST Requests unterstützt.");
    }

    /**
     * Diese Action dient dazu Bestellungen zu genehmigen
     * @return array
     */
    public function genehmigenAction() {

        // Bestellung servive benutzen
        /* @var $bestellungService \Application\Service\BestellungService */
        $bestellungService = $this->serviceLocator->get('Application\Service\Bestellung');

        // ..um alle "neuen" Bestellungen zu laden
        $bestellungen = $bestellungService->readAll();

        return array("bestellungen" => $bestellungen);
    }
}
