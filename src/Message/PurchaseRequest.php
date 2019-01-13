<?php

namespace Omnipay\CaspianPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getCode()
    {
        return $this->getParameter('code');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCode($value)
    {
        return $this->setParameter('code', $value);
    }


    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'token',
            'code',
            'amount',
            'currency'
        );

        if ($this->getCurrency() !== 'AZN') {
            throw new InvalidRequestException('Invalid currency. Only AZN is supported');
        }

        $data = [
            'code'   => $this->getCode(),
            'amount' => $this->getAmount(),
        ];

        return $data;
    }

    /**
     * @param array $data
     *
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        $uri = $this->createUri('partner/check_cp_code');
        $response = $this->httpClient
            ->post($uri, $this->createHeaders(), $data)
            ->send();

        $data = json_decode($response->getBody(true), true);
        return new PurchaseResponse($this, $data);
    }
}
