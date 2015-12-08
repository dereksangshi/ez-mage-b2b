<?php

namespace Ez\MageB2B\MongoDB;

use Ez\DataStructure\IndexedDeepMergeArray;

/**
 * Class Config
 *
 * @package Ez\MageB2B\MongoDB
 * @author Derek Li
 */
class Config extends IndexedDeepMergeArray
{
    /**
     * Constructor.
     * Set the default configuration.
     *
     */
    public function __construct()
    {
        $this->array = array(
            'dm' => array(
                'local' => array(
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
                            'proxy_dir' => __DIR__.'/Proxy',
                            'proxy_namespace' => 'Proxy',
                            'hydrator_dir' => __DIR__ . '/Hydrator',
                            'hydrator_namespace' => 'Hydrator',
                            'default_db' => 'mage_b2b',
                            'document_dir' => __DIR__ . '/Document'
                        )
                    )
                )
            ),
            'dm_default' => 'local'
        );
        parent::__construct();
    }

    /**
     * Update the configuration.
     *
     * @param array $config
     * @return $this
     */
    public function updateConfig(array $config)
    {
        $this->addArray($config);
        return $this;
    }
}
