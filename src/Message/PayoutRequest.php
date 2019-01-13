<?php

namespace Omnipay\CaspianPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PayoutRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }


    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'token',
            'account',
            'amount',
            'currency'
        );

        if ($this->getCurrency() !== 'AZN') {
            throw new InvalidRequestException('Invalid currency. Only AZN is supported');
        }

        $data = [
            'account' => $this->getAccount(),
            'amount'  => $this->getAmount(),
        ];

        return $data;
    }

    /**
     * @param array $data
     *
     * @return PayoutResponse
     */
    public function sendData($data)
    {
        $uri = $this->createUri('partner/payout');
        $response = $this->httpClient
            ->post($uri, $this->createHeaders())
            ->setBody(json_encode($data), 'application/json')
            ->send();

        $data = json_decode($response->getBody(true), true);
        return new PayoutResponse($this, $data);
    }
}
