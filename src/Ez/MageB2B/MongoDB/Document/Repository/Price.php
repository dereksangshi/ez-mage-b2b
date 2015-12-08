<?php

namespace Ez\MageB2B\MongoDB\Document\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Ez\MageB2B\MongoDB\Document\Price as PriceDocument;
use Doctrine\ODM\MongoDB\Cursor as MongoDBCursor;

/**
 * Class Price
 *
 * @package Ez\MageB2B\MongoDB\Document\Repository
 * @author Derek Li
 */
class Price extends DocumentRepository
{
    /**
     * Get the basic query to query 'price' collection.
     *
     * @param array $criteria The criteria to apply.
     *      Sample criteria:
     *          array(
     *              'select' => array(
     *                  'customer_code',
     *                  'product_sku'
     *              ),
     *              'where' => array(
     *                  'customer_code' => 'xxxx',
     *                  'product_sku' => array(
     *                      'sku1',
     *                      'sku2'
     *                  )
     *              ),
     *              'sort' => array(
     *                  'product_sku' => 'asc'
     *              )
     *              'limit' => 50,
     *              'skip' => 120
     *          );
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    public function getBasicQuery(array $criteria)
    {
        $query = $this
            ->getDocumentManager()
            ->createQueryBuilder('\\Ez\\MageB2B\\MongoDB\\Document\\Price');

        // Apply 'select' if it's passed through.
        if (array_key_exists('select', $criteria) &&
            $criteria['select'] != '*'
        ) {
            $criteria['select'] = is_array($criteria['select']) ?
                $criteria['select'] :
                array($criteria['select']);
            $query->select($criteria['select']);
        }

        // Apply 'where' if it's passed through.
        if (array_key_exists('where', $criteria)) {
            // Filter 'customer_code'.
            if (isset($criteria['where']['customer_code'])) {
                if (is_array($criteria['where']['customer_code'])) {
                    $query->field('customerCode')->in($criteria['where']['customer_code']);
                } else {
                    $query->field('customerCode')->equals($criteria['where']['customer_code']);
                }
            }
            // Filter product_sku
            if (isset($criteria['where']['product_sku'])) {
                if (is_array($criteria['where']['product_sku'])) {
                    $query->field('productSku')->in($criteria['where']['product_sku']);
                } else {
                    $query->field('productSku')->equals($criteria['where']['product_sku']);
                }
            }
        }

        // Apply 'sort' if it's passed.
        if (array_key_exists('sort', $criteria) &&
            is_array($criteria['sort'])
        ) {
            foreach ($criteria['sort'] as $field => $dir) {
                $query->sort($field, $dir);
            }
        }

        // Apply limit if it's passed.
        if (array_key_exists('limit', $criteria) &&
            isset($criteria['limit'])
        ) {
            $query->limit($criteria['limit']);
        }

        // Apply skip if it's passed.
        if (array_key_exists('skip', $criteria) &&
            isset($criteria['skip'])
        ) {
            $query->skip($criteria['skip']);
        }

        return $query;
    }

    /**
     * Map the price document into array.
     *
     * @param PriceDocument $priceDocument
     * @return array
     */
    protected function mapPriceDocumentIntoArray(PriceDocument $priceDocument)
    {
        return array(
            'id' => $priceDocument->getId(),
            'customer_code' => $priceDocument->getCustomerCode(),
            'product_sku' => $priceDocument->getProductSku(),
            'price' => $priceDocument->getPrice(),
            'tier_price' => $priceDocument->getTierPrice(),
            'updated_at' => $priceDocument->getUpdatedAt(),
            'etc' => $priceDocument->getEtc()
        );
    }

    /**
     * Map price collection into an array.
     *
     * @param array|MongoDBCursor $priceCollection
     * @return array
     */
    protected function mapPriceDocumentCollectionIntoArray($priceCollection)
    {
        $pricesArray = array();
        if (is_array($priceCollection) || $priceCollection instanceof MongoDBCursor) {
            foreach ($priceCollection as $priceDocument) {
                /**
                 * @var $p PriceDocument
                 */
                $pricesArray[] = $this->mapPriceDocumentIntoArray($priceDocument);
            }
        }
        return $pricesArray;
    }

    /**
     * Get the prices for the given customer.
     * Each price will be presented as an array.
     *
     * @param $customerCode
     * @param null|int $limit
     * @param int $skip
     * @return mixed
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getPricesArrayForCustomer($customerCode, $limit = null, $skip = 0)
    {
        $criteria = array(
            'where' => array(
                'customer_code' => $customerCode
            ),
            'sort' => 'id',
            'limit' => $limit,
            'skip' => $skip
        );
        $prices = $this
            ->getBasicQuery($criteria)
            ->getQuery()
            ->execute();
        return $this->mapPriceDocumentCollectionIntoArray($prices);
    }

    /**
     * Get prices in an array.
     *
     * @param array $criteria The criteria to apply.
     * @return array
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getPricesArray(array $criteria = array())
    {
        $prices = $this
            ->getBasicQuery($criteria)
            ->getQuery()
            ->execute();
        return $this->mapPriceDocumentCollectionIntoArray($prices);
    }

    /**
     * Count the records in the collection.
     *
     * @param array $criteria
     * @return int
     */
    public function count(array $criteria)
    {
        return $this
            ->getBasicQuery($criteria)
            ->getQuery()
            ->count();
    }
}