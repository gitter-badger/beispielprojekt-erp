<?php
namespace Application\Entity;

/**
 *
 */
class Material
{
    /**
     * Eindeutiger Identifier
     * @var integer
     */
    private $id;

    /**
     * Bezeichnung des Materials
     * @var string
     */
    private $bezeichnung;

    /**
     * Preis des Materials, pro Stück
     * @var double
     */
    private $preis;

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
     * @return float
     */
    public function getPreis()
    {
        return $this->preis;
    }

    /**
     * @param float $preis
     */
    public function setPreis($preis)
    {
        $this->preis = $preis;
    }
}