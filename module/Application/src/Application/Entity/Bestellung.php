<?php
namespace Application\Entity;

/**
 *
 */
class Bestellung
{
    /**
     * Eindeutiger Identifier
     * @var integer
     */
    private $id;

    /**
     * Bezeichnung der Bestellung
     * @var string
     */
    private $bezeichnung;

    /**
     * Material, das bestellt werden soll
     * @var Material
     */
    private $material;

    /**
     * Anzahl des zu bestellenden Materials
     * @var integer
     */
    private $anzahl;

    /**
     * Status, in dem die Bestellung sich befindet
     * @var string
     */
    private $status;

    /**
     * Zeitpunkt, wann die Bestellung erstellt wurde
     * @var \DateTime
     */
    private $zeitErstellt;

    /**
     * Zeitpunkt, wann die Bestellung genehmigt wurde
     * @var \DateTime
     */
    private $zeitGenehmigt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBezeichnung()
    {
        return $this->bezeichnung;
    }

    /**
     * @param string $bezeichnung
     */
    public function setBezeichnung($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
    }

    /**
     * @return Material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param Material $material
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * @return int
     */
    public function getAnzahl()
    {
        return $this->anzahl;
    }

    /**
     * @param int $anzahl
     */
    public function setAnzahl($anzahl)
    {
        $this->anzahl = $anzahl;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return DateTime
     */
    public function getZeitErstellt()
    {
        return $this->zeitErstellt;
    }

    /**
     * @param DateTime $zeitErstellt
     */
    public function setZeitErstellt($zeitErstellt)
    {
        $this->zeitErstellt = $zeitErstellt;
    }

    /**
     * @return DateTime
     */
    public function getZeitGenehmigt()
    {
        return $this->zeitGenehmigt;
    }

    /**
     * @param DateTime $zeitGenehmigt
     */
    public function setZeitGenehmigt($zeitGenehmigt)
    {
        $this->zeitGenehmigt = $zeitGenehmigt;
    }

    /**
     * Generiert einen hash für diese Bestellung
     * @return string
     */
    public function hash() {

        // Generiere einen für dieses Bestellung Objekt eindeutigen hash
        return md5($this->id . $this->material->hash() . $this->zeitErstellt->getTimestamp());
    }
}