<?php
namespace Application\Service;

use \Application\Entity\Material;

/**
 * Diese Service Klasse ist dafür gedacht, sich um alles zu kümmern,
 * das mit Materialien zu tun hat.
 */
class MaterialService
{
    /**
     * @var \Application\TableGateway\Material
     */
    private $materialTable;

    /**
     * Liefert alle bestellbaren Materialien
     * @return array
     */
    public function getMaterialien() {

        // Leeren array für die verfügbaren Materialien definieren
        $materialArray = array();

        // Materialdaten in entities verbacken
        foreach($this->materialTable->select()->toArray() as $idx => $material) {

            // Neue Material Entity bauen
            $materialEntity = new Material();

            // Attribute übernehmen
            $materialEntity->setId($material['id']);
            $materialEntity->setBezeichnung($material['bezeichnung']);
            $materialEntity->setPreis($material['preis']);

            $materialArray[] = $materialEntity;
        }

        // Array mit verfügbaren Materialien zurückgeben
        return $materialArray;
    }

    /**
     * Liefert das Material Object anhand der übergebenen id
     * @return Material|null
     */
    public function getMaterialById($id) {

        // NOTICE: unperformanter Code!...

        // Alle Materialien laden
        $materialien = $this->getMaterialien();

        /* @var $material Material */
        foreach($materialien as $material) {

            // ID Abgleich
            if($material->getId() == $id) {

                return $material;
            }
        }
    }

    /**
     * @param mixed $materialTable
     */
    public function setMaterialTable($materialTable)
    {
        $this->materialTable = $materialTable;
    }

    /**
     * @return mixed
     */
    public function getMaterialTable()
    {
        return $this->materialTable;
    }
}