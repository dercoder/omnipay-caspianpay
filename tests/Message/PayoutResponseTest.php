<?php

namespace Omnipay\CaspianPay\Message;

use Omnipay\Tests\TestCase;

class PayoutResponseTest extends TestCase
{
    /**
     * @var PayoutRequest
     */
    protected $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PayoutRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PayoutSuccess.txt');
        $response = new PayoutResponse($this->request, json_decode($httpResponse->getBody(true), true));

        $this->asserttrue($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(200, $response->getCode());
        $this->assertSame(200, $response->getStatus());
        $this->assertSame('Success', $response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
    }

    public function testFailure1()
    {
        $httpResponse = $this->getMockHttpResponse('PayoutFailure1.txt');
        $response = new PayoutResponse($this->request, json_decode($httpResponse->getBody(true), true));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(400, $response->getCode());
        $this->assertSame('Code not found or inactive', $response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
    }

    public function testFailure2()
    {
        $httpResponse = $this->getMockHttpResponse('PayoutFailure2.txt');
        $response = new PayoutResponse($this->request, json_decode($httpResponse->getBody(true), true));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(404, $response->getCode());
        $this->assertSame('Token not founded', $response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
    }

    public function testEmpty()
    {
        $httpResponse = $this->getMockHttpResponse('Empty.txt');
        $response = new PayoutResponse($this->request, json_decode($httpResponse->getBody(true), true));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
    }
}
