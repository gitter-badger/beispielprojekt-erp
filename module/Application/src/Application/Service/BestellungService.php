<?php
namespace Application\Service;

use \Application\Entity\Bestellung;

/**
 * Diese Service-Klasse ist dafür gedacht, sich umalles zu kümmern,
 * das mit Bestellungen zu tun hat.
 */
class BestellungService
{
    /**
     * @var \Application\TableGateway\Bestellung
     */
    private $bestellungTable;
    
    /**
     * @var MaterialService
     */
    private $materialService;

    /**
     * Funktion löst eine Bestellung aus
     * @param string $bezeichnung
     * @param \Application\Entity\Material $materialId
     * @param integer $anzahl
     */
    public function bestellen($bezeichnung, $materialId, $anzahl) {

        // Neues Bestellung-Objekt erzeugen
        $bestellung = new Bestellung();

        // Material anhand der übergebenen ID finden
        $material = $this->materialService->getMaterialById($materialId);

        // Befüllen mit den übergebenen Parametern
        $bestellung->setMaterial($material);
        $bestellung->setBezeichnung($bezeichnung);
        $bestellung->setAnzahl($anzahl);
        $bestellung->setStatus("neu");
        $bestellung->setZeitErstellt(new \DateTime());

        // Speichern
        $this->save($bestellung);
    }

    /**
     * Speichert die übergebene Bestellung
     * @param $bestellung Bestellung
     */
    private function save($bestellung) {

        // Speziellen Table Gateway für Bestellungen benutzen
        $tableGateway = new \Application\TableGateway\Bestellung();

        // Bestellung Entity in die Datenbank schreiben
        $tableGateway->insert(array("bezeichnung" => $bestellung->getBezeichnung(),
                                    "material" => $bestellung->getMaterial()->getId(),
                                    "anzahl" => $bestellung->getAnzahl(),
                                    "status" => $bestellung->getStatus(),
                                    "zeitErstellt" => $bestellung->getZeitErstellt()->format(\DateTime::ISO8601)));
    }

    /**
     * Lädt alle gespeicherten Bestellungen
     * @return array
     */
    private function readAll() {

        // TODO
    }

    /**
     * @return MaterialService
     */
    public function getMaterialService()
    {
        return $this->materialService;
    }

    /**
     * @param MaterialService $materialService
     */
    public function setMaterialService($materialService)
    {
        $this->materialService = $materialService;
    }

    /**
     * @return mixed
     */
    public function getBestellungTable()
    {
        return $this->bestellungTable;
    }

    /**
     * @param mixed $bestellungTable
     */
    public function setBestellungTable($bestellungTable)
    {
        $this->bestellungTable = $bestellungTable;
    }
}