<?php
namespace Application\Controller;

use Application\Service\ReportService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReportController extends AbstractActionController
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
     * Action liefert einen Report der Bestellungen in Kalenderwochen
     */
    public function bestellungenProKalenderwochenAction() {

        // Bestellungen pro Woche abfragen
        /** @var ReportService $reportService */
        $reportService = $this->serviceLocator->get('Application\Service\Report');

        // Report Daten von Service abfragen
        $bestellungenProKalenderwoche = $reportService->bestellungenProKalenderwochenCount();

        // Report Daten an die view übergeben
        return array("data" => $bestellungenProKalenderwoche);
    }
}
