<?php

namespace Ez\MageB2B\MongoDB;

use Doctrine\ODM\MongoDB\DocumentManager;
use Ez\MageB2B\MongoDB\Producer\ProducerInterface;
use Ez\Util\IndexedArray;

class MongoDB
{
    /**
     * @var Config
     */
    protected $config = null;

    /**
     * @var array
     */
    protected $documentManagers = array();

    /**
     * @var array
     */
    protected $producers = array();

    /**
     * Constructor.
     */
    public function __construct(Config $config = null)
    {
        $this->config = $config;
    }

    /**
     * @param Config $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $name
     * @return ProducerInterface
     */
    public function getProducer($name)
    {
        if (!array_key_exists($name, $this->producers)) {
            $this->loadProducer($name);
        }
        return $this->producers[$name];
    }

    /**
     * @param $name
     * @return $this
     */
    protected function loadProducer($name)
    {
        $className = sprintf(
            '\\Ez\\MageB2B\\MongoDB\\Producer\\%sProducer',
            ucfirst($name)
        );
        if (class_exists($className, true)) {
            $this->producers[$name] = new $className();
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * @param $name
     * @return $this
     */
    protected function loadDocumentManager($name)
    {
        $connectionConfig = $this->getConfig()->get("dm/{$name}/connection");
        $configurationConfig = $this->getConfig()->get("dm/{$name}/configuration");
        $this->documentManagers[$name] = DocumentManager::create(
            $this
                ->getProducer($connectionConfig['producer'])
                ->produce($connectionConfig['params']),
            $this
                ->getProducer($configurationConfig['producer'])
                ->produce($configurationConfig['params'])
        );
        return $this;
    }

    /**
     * @param $name
     * @return DocumentManager
     */
    public function getDocumentManager($name = null)
    {
        $name = isset($name) ? $name : $this->getConfig()->get('dm_default');
        if (!array_key_exists($name, $this->documentManagers)) {
            $this->loadDocumentManager($name);
        }
        return $this->documentManagers[$name];
    }
}