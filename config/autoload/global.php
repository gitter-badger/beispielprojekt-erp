<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($serviceManager) {
                $adapterFactory = new Zend\Db\Adapter\AdapterServiceFactory();

                // 
                return $adapterFactory->createService($serviceManager);
            }
        ),
    ),
    'php_settings' => array(
        'date.timezone' => 'Europe/Berlin'
    )
);
