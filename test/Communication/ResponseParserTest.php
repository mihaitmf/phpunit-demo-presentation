<?php

namespace Demo\Communication;

use PHPUnit\Framework\TestCase;

class ResponseParserTest extends TestCase
{
    /** @var ResponseParser */
    private $sut;

    protected function setUp(): void
    {
        $this->sut = new ResponseParser();
    }

    public function providerReferences()
    {
        return [
            'even values should be halved' => [5000, 2500],
            'odd values should stay the same' => [5001, 5001],
            '0 value' => [0, 0],
        ];
    }

    /**
     * @dataProvider providerReferences
     */
    public function testParseSuccessResponse($testReference, $expectedReference)
    {
        // given
        $jsonResponse = '{"status":"ok","reason":"Success message","id":' . $testReference . ',"extra":"some details"}';
        $expectedIsSuccessful = true;
        $expectedMessage = 'Success message';

        // when
        $actualResponse = $this->sut->parse($jsonResponse);

        // then
        $this->assertInstanceOf(Response::class, $actualResponse, 'Assertion on instance type failed');
        $this->assertSame($expectedIsSuccessful, $actualResponse->isSuccessful(), 'Assertion on "isSuccessful" failed');
        $this->assertSame($expectedMessage, $actualResponse->getMessage(), 'Assertion on "message" failed');
        $this->assertSame($expectedReference, $actualResponse->getReference(), 'Assertion on "reference" failed');
    }

    public function testParseErrorResponse()
    {
        // given
        $jsonResponse = '{"status":"fail","reason":"An error occurred because...","id":1234,"extra":"some details"}';
        $expectedIsSuccessful = false;
        $expectedMessage = 'ERROR - An error occurred because...';

        // when
        $actualResponse = $this->sut->parse($jsonResponse);

        // then
        $this->assertSame($expectedIsSuccessful, $actualResponse->isSuccessful(), 'Assertion on "isSuccessful" failed');
        $this->assertSame($expectedMessage, $actualResponse->getMessage(), 'Assertion on "message" failed');
    }

    public function testParseShouldThrowExceptionForInvalidJsonStatus()
    {
        // given
        $jsonResponse = '{"status":"aaa","reason":"An error occurred because...","id":1234,"extra":"some details"}';

        // then
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid response status");

        // when
        $this->sut->parse($jsonResponse);
    }
}

