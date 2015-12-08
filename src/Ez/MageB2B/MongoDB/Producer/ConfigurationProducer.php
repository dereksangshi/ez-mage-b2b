<?php

namespace Ez\MageB2B\MongoDB\Producer;

use Doctrine\ODM\MongoDB\Configuration as Configuration;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class ConfigurationProducer implements ProducerInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function produce(array $params = array())
    {
        $configuration = new Configuration();
        $configuration->setProxyDir($params['proxy_dir']);
        $configuration->setProxyNamespace($params['proxy_namespace']);
        $configuration->setHydratorDir($params['hydrator_dir']);
        $configuration->setHydratorNamespace($params['hydrator_namespace']);
        $configuration->setDefaultDB($params['default_db']);
        $configuration->setMetadataDriverImpl(AnnotationDriver::create($params['document_dir']));
        AnnotationDriver::registerAnnotationClasses();
        return $configuration;
    }
}
