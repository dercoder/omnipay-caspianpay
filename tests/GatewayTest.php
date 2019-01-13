<?php

namespace Omnipay\CaspianPay;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    public $gateway;

    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setToken('fma7m2r2l15wtCUz0W9qhlgterKzsrfJbFrs2kK4GL936');
    }

    public function testCredentials()
    {
        $this->assertSame('fma7m2r2l15wtCUz0W9qhlgterKzsrfJbFrs2kK4GL936', $this->gateway->getToken());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'code'     => '6879870870987',
            'amount'   => 12.43,
            'currency' => 'AZN',
        ]);

        $this->assertInstanceOf('\Omnipay\CaspianPay\Message\PurchaseRequest', $request);
    }

    public function testPayout()
    {
        $request = $this->gateway->payout([
            'account'  => '9955455566',
            'amount'   => 12.43,
            'currency' => 'AZN',
        ]);

        $this->assertInstanceOf('\Omnipay\CaspianPay\Message\PayoutRequest', $request);
    }
}
