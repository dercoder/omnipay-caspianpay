<?php

namespace Omnipay\CaspianPay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'https://caspianpay.az/api/v1';

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function createUri($path)
    {
        return sprintf('%s/%s', $this->getEndpoint(), $path);
    }

    /**
     * @return array
     */
    protected function createHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getToken(),
        ];
    }
}
