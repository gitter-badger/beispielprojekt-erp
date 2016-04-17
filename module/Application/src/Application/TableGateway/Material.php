<?php
namespace Application\TableGateway;

use \Zend\Db\TableGateway\TableGateway;
use \Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use \Zend\Db\TableGateway\Feature\FeatureSet;

class Material extends TableGateway
{
    public function __construct()
    {
        $this->table = 'material';
        $this->featureSet = new FeatureSet();
        $this->featureSet->addFeature(new GlobalAdapterFeature());
        $this->initialize();
    }
}