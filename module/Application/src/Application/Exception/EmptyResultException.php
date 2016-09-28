<?php
namespace Application\Exception;

/**
 *
 */
class EmptyResultException extends \Exception
{
    protected $message = "Es wurden für diese Abfrage keine Daten in der Datenbank gefunden.";
}