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
     * @var MaterialService
     */
    private $materialService;

    /**
     * Funktion löst eine Bestellung aus
     * @param string $bezeichnung
     * @param \Application\Entity\Material $material
     * @param integer $anzahl
     */
    public function bestellen($bezeichnung, $material, $anzahl) {

        // Neues Bestellung-Objekt erzeugen
        $bestellung = new Bestellung();

        // Material anhand
        $material =

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

        // Speichere die Serialisierte Version dieses Objekts im filesystem
        file_put_contents("data/objects/". $bestellung->hash(), serialize($bestellung));
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
}