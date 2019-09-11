<?php

namespace Demo\Communication;

use PHPUnit\Framework\TestCase;

class ApiClientComponentTest extends TestCase
{
    /** @var ApiClient */
    private $sut;

    /** @var HttpClient */
    private $httpClientStub;

    protected function setUp(): void
    {
        $this->httpClientStub = $this->createMock(HttpClient::class);

        $this->sut = new ApiClient($this->httpClientStub, new ResponseParser());
    }

    public function testCallApiSuccess()
    {
        $requestArray = [];

        $jsonResponse = '{"status":"ok","reason":"Success message","id":1250,"extra":"some details"}';
        $this->httpClientStub->method('makeHttpRequest')
            ->willReturn($jsonResponse);

        $expectedIsSuccessful = true;
        $expectedMessage = 'Success message';
        $expectedReference = 625;

        $actualResponse = $this->sut->callApi($requestArray);

        $this->assertSame($expectedIsSuccessful, $actualResponse->isSuccessful(), 'Assertion on "isSuccessful" failed');
        $this->assertSame($expectedMessage, $actualResponse->getMessage(), 'Assertion on "message" failed');
        $this->assertSame($expectedReference, $actualResponse->getReference(), 'Assertion on "reference" failed');
    }
}
