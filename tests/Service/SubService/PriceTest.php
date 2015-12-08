<?php

namespace Ez\MageB2B\Tests\Service\SubService;

use Ez\MageB2B\MongoDB\MongoDB;
use Ez\MageB2B\MongoDB\Config as MongoDBConfig;

use Ez\MageB2B\ServiceInventory;
use Ez\Service\InventoryConfig;

/**
 * Class PriceTest
 *
 * @package Ez\MageB2B\Tests\MongoDB\Document
 * @author Derek Li
 */
class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function testPriceServiceModule()
    {
        $mongoDBConfig = new MongoDBConfig();
        $ezMongoB2BPackageMongoDBDir = __DIR__.'/../../../src/Ez/MageB2B/MongoDB';
        $mongoDbInfo = array(
            'dm' => array(
                'production' => array(
                    'connection' => array(
                        'producer' => 'connection',
                        'params' => array(
                            'host' => '127.0.0.1',
                            'port' => '27017',
                            'username' => 'mage_b2b',
                            'password' => 'balance08',
                            'db' => 'mage_b2b'
                        )
                    ),
                    'configuration' => array(
                        'producer' => 'configuration',
                        'params' => array(
                            'proxy_dir' => $ezMongoB2BPackageMongoDBDir.'/Proxy',
                            'proxy_namespace' => 'Proxy',
                            'hydrator_dir' => $ezMongoB2BPackageMongoDBDir . '/Hydrator',
                            'hydrator_namespace' => 'Hydrator',
                            'default_db' => 'mage_b2b',
                            'document_dir' => $ezMongoB2BPackageMongoDBDir . '/Document'
                        )
                    )
                )
            ),
            'dm_default' => 'production'
        );
        $mongoDBConfig->updateConfig($mongoDbInfo);
        $mongoDB = new MongoDB($mongoDBConfig);
        $documentManager = $mongoDB->getDocumentManager();
        $documentManager->getSchemaManager()->ensureIndexes();

        // Get the service inventory.
        $serviceConfig = new InventoryConfig();
        $serviceConfig->addArray(array(
            'document_manager' => $documentManager
        ));
        $service = new ServiceInventory($serviceConfig);
        print_r($service->_price_()->_getPricesArray_());
        print_r($service->_price_()->_getPricesArrayForCustomer_('c_c_1', 3));
        print_r($service->_price_()->_count_());
    }
}