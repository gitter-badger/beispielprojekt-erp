<?php
namespace Application\TableGateway;

use \Zend\Db\TableGateway\TableGateway;
use \Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use \Zend\Db\TableGateway\Feature\FeatureSet;

class Bestellung extends TableGateway
{
    public function __construct()
    {
        $this->table = 'bestellung';
        $this->featureSet = new FeatureSet();
        $this->featureSet->addFeature(new GlobalAdapterFeature());
        $this->initialize();
    }
}