<?php

namespace Demo\Communication;

use PHPUnit\Framework\TestCase;

class ApiClientTest extends TestCase
{
    /** @var ApiClient */
    private $sut;

    /** @var ResponseParser */
    private $responseParserMock;

    /** @var HttpClient */
    private $httpClientStub;

    protected function setUp(): void
    {
        $this->httpClientStub = $this->createMock(HttpClient::class);
        $this->responseParserMock = $this->createMock(ResponseParser::class);

        $this->sut = new ApiClient($this->httpClientStub, $this->responseParserMock);
    }

    public function testCallApiSuccessResponse()
    {
        $requestArray = [];
        $dummyJsonResponse = 'sample response';
        $responseStub = $this->createMock(Response::class);

        $this->httpClientStub->method('makeHttpRequest')
            ->willReturn($dummyJsonResponse);

        $this->responseParserMock->expects($this->once())
            ->method('parse')
            ->with($dummyJsonResponse)
            ->willReturn($responseStub);

        $actualResponse = $this->sut->callApi($requestArray);

        $this->assertSame($responseStub, $actualResponse, 'The returned Response object is different than expected');
    }
}
