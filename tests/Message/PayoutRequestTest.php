<?php

namespace Omnipay\CaspianPay\Message;

use Omnipay\Tests\TestCase;

class PayoutRequestTest extends TestCase
{
    /**
     * @var PayoutRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PayoutRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'token'    => 'fma7m2r2l15wtCUz0W9qhlgterKzsrfJbFrs2kK4GL936',
            'account'  => '9955455566',
            'amount'   => 12.43,
            'currency' => 'AZN',
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('9955455566', $data['account']);
        $this->assertSame('12.43', $data['amount']);
    }

    public function testInvalidCurrency()
    {
        $this->request->setCurrency('EUR');
        $this->setExpectedException('\Omnipay\Common\Exception\InvalidRequestException');
        $this->request->getData();
    }

    public function testSendData()
    {
        $this->setMockHttpResponse('PayoutSuccess.txt');
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\CaspianPay\Message\PayoutResponse', $response);
    }
}
