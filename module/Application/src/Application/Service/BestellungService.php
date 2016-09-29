<?php
namespace Application\Service;

use \Application\Entity\Bestellung;
use Application\Exception\EmptyResultException;

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
     * @var MailService
     */
    private $mailService;

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
     * Funktion setzt die Bestellung auf Status genehmigt
     *
     * @param $bestellung Bestellung
     */
    public function genehmigen($bestellung) {

        // Status der Bestellung auf "genehmigt" ändern
        $bestellung->setStatus("genehmigt");
        $bestellung->setZeitGenehmigt(new \DateTime());

        // Datensatz mit geänderten Daten aktualisieren
        $this->update($bestellung);

        // E-Mail Benachrichtigung versenden
        $this->mailService->benachrichtigen($bestellung);
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
     * Aktualisiert die bereits vorhandnen Daten in der Datenbank
     * @param $bestellung Bestellung
     */
    private function update($bestellung) {

        // Speziellen Table Gateway für Bestellungen benutzen
        $tableGateway = new \Application\TableGateway\Bestellung();

        // Kompletten Datensatz mit geänderten Werten aktualisieren
        $tableGateway->update(array("bezeichnung" => $bestellung->getBezeichnung(),
                                    "material" => $bestellung->getMaterial()->getId(),
                                    "anzahl" => $bestellung->getAnzahl(),
                                    "status" => $bestellung->getStatus(),
                                    "zeitGenehmigt" => $bestellung->getZeitGenehmigt()->format(\DateTime::ISO8601)),
                              array("id" => $bestellung->getId()));
    }

    /**
     * Lädt alle gespeicherten Bestellungen
     *
     * @param $idOrder string Legt die Sortierung der ID-Spalte fest. Werte sind 'asc' oder 'desc'. 'asc' ist default
     * @return array
     */
    public function getBestellungen($idOrder = "asc") {

        // Speziellen Table Gateway benutzen
        $tableGateway = new \Application\TableGateway\Bestellung();

        // Select SQL zusammenbauen
        $selectSql = new \Zend\Db\Sql\Select();
        $selectSql->from($tableGateway->getTable())
                  ->order(array("id" => $idOrder));

        // Alle Bestellungen abrufen
        $bestellungenResultSet = $tableGateway->selectWith($selectSql);

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
     * Lädt Datensatz anhand der übergebenen ID aus der Datenbank
     * @param $bestellungId integer
     * @return Bestellung
     * @throws EmptyResultException
     */
    public function getBestellungById($bestellungId) {

        // Speziellen Table Gateway benutzen
        $tableGateway = new \Application\TableGateway\Bestellung();

        // Alle Bestellungen abrufen
        $bestellungenResultSet = $tableGateway->select(array("id" => $bestellungId));

        // Exception werfen falls keine Daten gefunden
        if($bestellungenResultSet->count() == 0) {
            throw new EmptyResultException();
        }

        // Greife auf das erste Ergebnis in der Ergebnismenge zu
        $bestellungData = $bestellungenResultSet->current();

        // ...und befülle ein Entity Objekt damit
        $bestellungEntity = new Bestellung();

        $bestellungEntity->setId($bestellungData['id']);
        $bestellungEntity->setBezeichnung($bestellungData['bezeichnung']);
        $bestellungEntity->setAnzahl($bestellungData['anzahl']);
        $bestellungEntity->setStatus($bestellungData['status']);
        $bestellungEntity->setZeitErstellt(new \DateTime($bestellungData['zeitErstellt']));
        $bestellungEntity->setZeitGenehmigt(new \DateTime($bestellungData['zeitGenehmigt']));

        // Material Entity laden und vekrnüpfen
        $materialEntity = $this->materialService->getMaterialById($bestellungData['material']);
        $bestellungEntity->setMaterial($materialEntity);

        // Mit Daten befüllte Entity zurückgeben
        return $bestellungEntity;
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
     * @return MailService
     */
    public function getMailService()
    {
        return $this->mailService;
    }

    /**
     * @param MailService $mailService
     */
    public function setMailService($mailService)
    {
        $this->mailService = $mailService;
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