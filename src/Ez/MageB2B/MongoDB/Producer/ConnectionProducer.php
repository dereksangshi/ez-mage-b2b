<?php

namespace Ez\MageB2B\MongoDB\Producer;

use Doctrine\MongoDB\Connection;

class ConnectionProducer implements ProducerInterface
{
    /**
     * @param array $params
     * @return mixed|void
     */
    public function produce(array $params = array())
    {
        $server = 'mongodb://';
        if (array_key_exists('username', $params) &&
            !empty($params['username']) &&
            array_key_exists('password', $params) &&
            !empty($params['password'])
        ) {
            $server = sprintf(
                '%s%s:%s@',
                $server,
                $params['username'],
                $params['password']
            );
        }
        $port = (array_key_exists('port', $params)) && $params['port'] ?
            $params['port'] :
            '27017';
        $server = sprintf('%s%s:%s', $server, $params['host'], $port);
        if (array_key_exists('db', $params) &&
            !empty($params['db'])
        ) {
            $server = sprintf('%s/%s', $server, $params['db']);
        }
        $options = array_key_exists('options', $params) && is_array($params['options']) ?
            $params['options'] :
            array();
        $connection = new Connection($server, $options);
        return $connection;
    }
}
