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
     * Liefert alle bestellbaren Materialien
     * @return array
     */
    public function getMaterialien() {

        // Gold
        $gold = new Material();
        $gold->setId(1);
        $gold->setBezeichnung("Gold");
        $gold->setPreis(1088.41);   // EUR je Feinunze

        // Silber
        $silber = new Material();
        $silber->setId(2);
        $silber->setBezeichnung("Silber");
        $silber->setPreis(14.33);   // EUR je Feinunze

        // Kupfer
        $kupfer = new Material();
        $kupfer->setId(3);
        $kupfer->setBezeichnung("Kupfer");
        $kupfer->setPreis(4304.29); // EUR je Tonne

        // Bestellbare Materialien zurückgeben
        return array($gold, $silber, $kupfer);
    }
}