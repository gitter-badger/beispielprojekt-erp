<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class BestellungController extends AbstractActionController
{
    /**
     * Diese Action dient dazu die Daten für eine Bestellung aufzunehmen
     * und den sntprechenden Prozess zu starten
     * @return array
     * @throws \Exception falls request weder GET noch POST ist
     */
    public function bestellenAction()
    {
        /* @var $request Zend_Controller_Request_Http */
        $request = $this->getRequest();

        // GET Kontext liefert die Eingabemaske
        if($request->isGet()) {

            // Material Service benutzen
            /* @var $materialService \Application\Service\MaterialService */
            $materialService = $this->getServiceLocator()->get('Application\Service\Material');

            // Bestellbare Materialien laden
            $materialien = $materialService->getMaterialien();

            // Liste bestellbarer Materialien an View übergeben
            return array('materialien' => $materialien);


        // POST Kontext verarbeitet die Bestellung
        } else if($request->isPost()) {

            // Bestellung Service benutzen
            /* @var $bestellungService \Application\Service\BestellungService */
            $bestellungService = $this->getServiceLocator()->get('Application\Service\Bestellung');

            // POST Parameter benutzen
            $postParams = $this->params()->fromPost();

            // Bestellung ausführen
            $bestellungService->bestellen($postParams['bezeichnung'], $postParams['material'], $postParams['anzahl']);

            // Nach erfolgreichem bestellen, weiterleiten auf das leere Bestellformular
            $this->redirect()->toRoute('application', array('controller' => 'Bestellung', 'action' => 'bestellen'));
        }

        throw new \Exception("Es werden hier nur GET oder POST Requests unterstützt.");
    }
}
