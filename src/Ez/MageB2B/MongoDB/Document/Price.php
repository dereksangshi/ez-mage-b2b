<?php

namespace Ez\MageB2B\MongoDB\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *      collection="price",
 *      indexes={
 *          @ODM\Index(keys={"customerCode"="asc", "productSku"="asc"}),
 *          @ODM\Index(keys={"productSku"="asc"})
 *      },
 *      repositoryClass="Ez\MageB2B\MongoDB\Document\Repository\Price"
 * )
 */
class Price
{
    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\Field(name="customer_code", type="string")
     */
    private $customerCode = null;

    /**
     * @ODM\Field(name="product_sku", type="string")
     */
    private $productSku = null;

    /**
     * @ODM\Field(name="price", type="float")
     */
    private $price = null;

    /**
     * @ODM\Field(name="tier_price", type="collection")
     */
    private $tierPrice = null;

    /**
     * @ODM\Field(name="updated_at", type="string")
     */
    private $updatedAt = null;

    /**
     * @ODM\Field(name="etc", type="string")
     */
    private $etc = null;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $customerCode
     * @return $this
     */
    public function setCustomerCode($customerCode)
    {
        $this->customerCode = $customerCode;
        return $this;
    }

    /**
     * @return null
     */
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * @param $productSku
     * @return $this
     */
    public function setProductSku($productSku)
    {
        $this->productSku = $productSku;
        return $this;
    }

    /**
     * @return null
     */
    public function getProductSku()
    {
        return $this->productSku;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param array $tierPrice
     * @return $this
     */
    public function setTierPrice(array $tierPrice)
    {
        $this->tierPrice = $tierPrice;
        return $this;
    }

    /**
     * @return array
     */
    public function getTierPrice()
    {
        return $this->tierPrice;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $etc
     * @return $this
     */
    public function setEtc($etc)
    {
        $this->etc = $etc;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtc()
    {
        return $this->etc;
    }
}