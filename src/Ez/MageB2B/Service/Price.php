<?php

namespace Ez\MageB2B\Service;

use Ez\Service\Module\ServiceModuleAbstract;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ez\Service\Output\Output;
use Ez\MageB2B\MongoDB\Document\Repository\Price as PriceRepository;

/**
 * Class Price
 *
 * @package Ez\MageB2B\Service
 * @author Derek Li
 */
class Price extends ServiceModuleAbstract
{
    /**
     * Get the document manager.
     *
     * @return DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this
            ->getConfig()
            ->get('document_manager');
    }

    /**
     * @return PriceRepository
     */
    public function getPriceRepository()
    {
        return $this
            ->getDocumentManager()
            ->getRepository('\\Ez\\MageB2B\\MongoDB\\Document\\Price');
    }

    /**
     * Get the prices for the given customer.
     * Each price will be presented as an array.
     *
     * @param string $customerCode The 'customer_code'.
     * @param null|int $limit
     * @param int $skip
     * @return Output
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getPricesArrayForCustomerService($customerCode, $limit = null, $skip = 0)
    {
        $output = new Output();
        try {
            $result = $this
                ->getPriceRepository()
                ->getPricesArrayForCustomer($customerCode, $limit, $skip);
            $output->setReturn($result);
        } catch (Exception $e) {
            $output->addError($e->getMessage());
        }
        return $output;
    }

    /**
     * Get prices in an array.
     *
     * @param array $criteria
     * @return Output
     */
    public function getPricesArrayService(array $criteria = array())
    {
        $output = new Output();
        try {
            $result = $this
                ->getPriceRepository()
                ->getPricesArray($criteria);
            $output->setReturn($result);
        } catch (Exception $e) {
            $output->addError($e->getMessage());
        }
        return $output;
    }

    /**
     * Count the records in the collection.
     *
     * @param array $criteria
     * @return Output
     */
    public function countService(array $criteria = array())
    {
        $output = new Output();
        try {
            $result = $this
                ->getPriceRepository()
                ->count($criteria);
            $output->setReturn($result);
        } catch (Exception $e) {
            $output->addError($e->getMessage());
        }
        return $output;
    }
}