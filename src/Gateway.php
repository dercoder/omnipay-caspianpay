<?php

namespace Omnipay\CaspianPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\CaspianPay\Message\PurchaseRequest;
use Omnipay\CaspianPay\Message\PayoutRequest;

class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'CaspianPay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'token'    => '',
            'testMode' => false,
        ];
    }

    /**
     * Get CaspianPay token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }

    /**
     * Set CaspianPay token.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\CaspianPay\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|PayoutRequest
     */
    public function payout(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\CaspianPay\Message\PayoutRequest', $parameters);
    }
}
