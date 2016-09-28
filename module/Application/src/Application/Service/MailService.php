<?php
namespace Application\Service;
use Application\Entity\Bestellung;
use Zend\Mail\Transport\SmtpOptions;

/**
 * Class MailService
 * @package Application\Service
 */
class MailService
{
    /**
     * Klasse für E-Mail Transport
     * @var \Zend\Mail\Transport\TransportInterface
     */
    private $mailTransport;

    /**
     * Adresse des E-Mail Senders
     * @var string
     */
    private $sender;

    /**
     * Adresse des E-Mail Empfängers
     * @var string
     */
    private $recipient;

    /**
     * MailService constructor.
     *
     * @param $config array
     */
    public function __construct($config) {

        // SMTP Optionen konfigurieren
        $smtpOptions = new SmtpOptions($config['mail']['transport']['options']);

        // SMTP für den Transport benutzen
        $this->mailTransport = new \Zend\Mail\Transport\Smtp($smtpOptions);


        // E-Mail Empfänger und Sender aus Konfiguration laden
        $this->sender = $config['mail']['service']['sender'];
        $this->recipient = $config['mail']['service']['recipient'];
    }

    /**
     * Funktion verschickt eine E-Mail mit einer kurzen Zusammenfassung der genehmigten Bestellung
     *
     * @param $bestellung Bestellung
     */
    public function benachrichtigen($bestellung) {

        // Nachricht zusammenstellen
        $mail = new \Zend\Mail\Message();
        $mail->setBody("Die nachfolgende Bestellung wurde genehmigt.\n\nBezeichnung: ". $bestellung->getBezeichnung(). "\nErstellt am: ". $bestellung->getZeitErstellt()->format("F j, Y, g:i a"))
             ->setEncoding('UTF-8')
             ->setFrom($this->sender)
             ->addTo($this->recipient)
             ->setSubject('Bestellung genehmigt');

        // E-Mail versenden
        $this->mailTransport->send($mail);
    }
}