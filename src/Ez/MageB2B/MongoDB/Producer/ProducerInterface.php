<?php

namespace Ez\MageB2B\MongoDB\Producer;

interface ProducerInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function produce(array $params = array());
}
