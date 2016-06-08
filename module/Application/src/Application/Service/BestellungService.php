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
    public function readAll() {

        // Speziellen Table Gateway benutzen
        $tableGateway = new \Application\TableGateway\Bestellung();

        // Alle Bestellungen abrufen
        $bestellungenResultSet = $tableGateway->select(array());

        // Leeres array für die geladenen Bestellung-Entities definieren
        $bestellungen = array();

        // Alle Bestellungen von array in entities umwandeln
        foreach($bestellungenResultSet->toArray() as $bestellung) {

            // Neue Bestellung Entity
            $bestellungEntity = new Bestellung();

            $bestellungEntity->setId($bestellung['id']);
            $bestellungEntity->setBezeichnung($bestellung['bezeichnung']);
            $bestellungEntity->setAnzahl($bestellung['anzahl']);
            $bestellungEntity->setStatus($bestellung['status']);
            $bestellungEntity->setZeitErstellt(new \DateTime($bestellung['zeitErstellt']));

            if($bestellung['zeitGenehmigt']) {
                $bestellungEntity->setZeitGenehmigt(new \DateTime($bestellung['zeitGenehmigt']));
            }

            // Verknüpftes Material entity laden
            $materialEntity = $this->materialService->getMaterialById($bestellung['material']);
            $bestellungEntity->setMaterial($materialEntity);

            // Entity in Result array einfügen
            $bestellungen[] = $bestellungEntity;
        }

        // Alle Bestellungen als Entities zurückgeben
        return $bestellungen;
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