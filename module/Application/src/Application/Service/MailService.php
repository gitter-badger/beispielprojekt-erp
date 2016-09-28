<?php
namespace Application\Service;
use Application\Entity\Bestellung;

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

        // Sendmail für den Transport benutzen
        $this->mailTransport = new \Zend\Mail\Transport\Sendmail();

        // E-Mail Empfänger und Sender aus Konfiguration laden
        $this->sender = $config['mail_service']['sender'];
        $this->recipient = $config['mail_service']['recipient'];
    }

    /**
     * Funktion verschickt eine E-Mail mit einer kurzen Zusammenfassung der genehmigten Bestellung
     *
     * @param $bestellung Bestellung
     */
    public function benachrichtigen($bestellung) {

        // Nachricht zusammenstellen
        $mail = new \Zend\Mail\Message();
        $mail->setBody('This is the text of the mail.')
             ->setFrom($this->sender, 'Beispielprojekt ERP')
             ->addTo($this->recipient, 'Empfänger')
             ->setSubject('Bestellung genehmigt');

        // E-Mail versenden
        $this->mailTransport->send($mail);
    }
}