<?php
namespace Application\Service;


use Application\Entity\Bestellung;

class ReportService
{
    /**
     * @var BestellungService
     */
    private $bestellungService;

    /**
     * Methode lädt alle Bestellungen aus der Datenbank und gruppiert sie nach Wochen und
     * nach neu bzw. genehmigt
     *
     * @return array
     */
    public function bestellungenProKalenderwochenCount() {

        // Alle Bestellungen laden
        $bestellungen = $this->bestellungService->getBestellungen();

        // Überprüfen, ob Bestellungen überhaupt vorliegen
        if(count($bestellungen) == 0) {

            // ...falls ja, leeres Array zurückgeben
            return array();
        }

        // Initialisiere ein array für die Statstiken
        $ergebnisArray = array();

        /** @var Bestellung $bestellung */
        foreach($bestellungen as $bestellung) {

            // Kalenderwoche "erstellt" ermitteln
            $kalenderwocheErstellt = $bestellung->getZeitErstellt()->format("Y-W");

            // Überprüfe, ob für die Kalenderwoche bereits ein Datensatz existiert
            if(!isset($ergebnisArray[$kalenderwocheErstellt])) {

                $ergebnisArray[$kalenderwocheErstellt] = array("erstellt" => 0, "genehmigt" => 0);
            }

            // Anzahl für "erstellt" hochzählen
            $ergebnisArray[$kalenderwocheErstellt]["erstellt"]++;


            // Überprüfen, ob diese Bestellung beeits genehmigt wurde
            if($bestellung->getStatus() == "genehmigt") {

                // Kalenderwoche "genehmigt" ermitteln
                $kalenderwocheGenehmigt = $bestellung->getZeitGenehmigt()->format("Y-W");

                // Überprüfe, ob für die Kalenderwoche bereits ein Datensatz existiert
                if(!isset($ergebnisArray[$kalenderwocheGenehmigt])) {

                    $ergebnisArray[$kalenderwocheGenehmigt] = array("erstellt" => 0, "genehmigt" => 0);
                }

                // Anzahl für "genehmigt" hochzählen
                $ergebnisArray[$kalenderwocheErstellt]["genehmigt"]++;
            }
        }

        //
        return $ergebnisArray;
    }

    /**
     * @return BestellungService
     */
    public function getBestellungService()
    {
        return $this->bestellungService;
    }

    /**
     * @param BestellungService $bestellungService
     */
    public function setBestellungService($bestellungService)
    {
        $this->bestellungService = $bestellungService;
    }
}