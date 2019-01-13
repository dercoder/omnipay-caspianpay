<?php

namespace Omnipay\CaspianPay\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'token'    => 'fma7m2r2l15wtCUz0W9qhlgterKzsrfJbFrs2kK4GL936',
            'code'     => '6879870870987',
            'amount'   => 12.43,
            'currency' => 'AZN',
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('6879870870987', $data['code']);
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
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\CaspianPay\Message\PurchaseResponse', $response);
    }
}
