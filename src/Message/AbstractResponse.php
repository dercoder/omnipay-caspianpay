<?php

namespace Omnipay\CaspianPay\Message;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    protected $messages = [
        200 => 'Success',
        300 => 'Code price and amount are different',
        350 => 'Code price is higher or lower than amount',
        400 => 'Code not found or inactive',
        500 => 'Code or amount fields are empty',
    ];

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getStatus() === 200;
    }

    /**
     * @return int|null
     */
    public function getCode()
    {
        return isset($this->data['error']) ? (int)$this->data['error'] : $this->getStatus();
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (isset($this->data['message'])) {
            return $this->data['message'];
        } elseif ($status = $this->getStatus()) {
            return isset($this->messages[$status]) ? $this->messages[$status] : null;
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return isset($this->data['status']) ? (int)$this->data['status'] : null;
    }
}
