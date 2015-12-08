<?php

namespace Ez\MageB2B\Tests\MongoDB\Document;

use Ez\MageB2B\MongoDB\Document\Price as PriceDocument;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ez\MageB2B\MongoDB\MongoDB;
use Ez\MageB2B\MongoDB\Config as MongoDBConfig;

/**
 * Class TestDbDocumentPrice
 * @package Ez\MageB2B\Db\Document
 * @author Derek Li
 */
class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function documentManagerProvider()
    {
        $config = new MongoDBConfig();
        $mongoDB = new MongoDB($config);
        $documentManager = $mongoDB->getDocumentManager();
        $documentManager->getSchemaManager()->ensureIndexes();
        return array(array($documentManager));
    }

    /**
     * @dataProvider documentManagerProvider
     */
    public function testDocumentAccess(DocumentManager $documentManager)
    {
        $customerCodes = array(
            'DEFAULT_CUSTOMER_CODE',
            'c_c_1',
            'c_c_2',
            'c_c_3',
            'c_c_4',
            'c_c_5',
            'c_c_6',
            'L14229'
        );
        $productSkus = array(
            '33000780',
            '13270600',
            '21000425',
            '33003700',
            '21120120',
            '26002375',
            '26002105',
            '24120885',
            '24120410',
            '21120135'
        );
        foreach ($customerCodes as $c) {
            foreach ($productSkus as $p) {
                $priceDocument = new PriceDocument();
                $priceDocument->setCustomerCode($c);
                $priceDocument->setProductSku($p);
                $priceDocument->setPrice(29.92);
                $priceDocument->setTierPrice(array(
                    array(
                        'qty' => '2.00',
                        'price' => '19.95'
                    ),
                    array(
                        'qty' => '5.00',
                        'price' => '18.95'
                    )
                ));
                $priceDocument->setUpdatedAt(date('Y-m-d H:i:s'));
                $priceDocument->setEtc(sprintf("This is the price for customer %s for product %s.", $c, $p));
                $documentManager->persist($priceDocument);
            }
        }
//        $documentManager->flush();
//        print_r(get_class($documentManager->getRepository('\\Ez\\MageB2B\\MongoDB\\Document\\Price')));
//        $this->assertTrue($priceDocument->getPrice());
    }
}