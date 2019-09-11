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
            'even reference should be halved' => [1250, 625],
            'odd reference should stay the same' => [1251, 1251],
        ];
    }

    /**
     * @dataProvider providerReferences
     */
    public function testParseSuccessResponse($jsonReference, $expectedReference)
    {
        $expectedIsSuccessful = true;
        $expectedMessage = 'Success message';

        $jsonResponse = sprintf(
            '{"status":"ok","reason":"Success message","id":%d,"extra":"some details"}',
            $jsonReference
        );

        $actualResponse = $this->sut->parse($jsonResponse);

        $this->assertSame($expectedIsSuccessful, $actualResponse->isSuccessful(), 'Assertion on "isSuccessful" failed');
        $this->assertSame($expectedMessage, $actualResponse->getMessage(), 'Assertion on "message" failed');
        $this->assertSame($expectedReference, $actualResponse->getReference(), 'Assertion on "reference" failed');
    }

    public function testParseErrorResponse()
    {
        $expectedIsSuccessful = false;
        $expectedMessage = 'ERROR - Invalid response';
        $expectedReference = 1234;

        $jsonResponse = '{"status":"fail","reason":"Invalid response","id":1234,"extra":"some details"}';

        $actualResponse = $this->sut->parse($jsonResponse);

        $this->assertSame($expectedIsSuccessful, $actualResponse->isSuccessful(), 'Assertion on "isSuccessful" failed');
        $this->assertSame($expectedMessage, $actualResponse->getMessage(), 'Assertion on "message" failed');
        $this->assertSame($expectedReference, $actualResponse->getReference(), 'Assertion on "reference" failed');
    }

    public function testParseExceptionForInvalidResponseStatus()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid response status: something');

        $jsonResponse = '{"status":"something","reason":"Success message","id":1234,"extra":"some details"}';

        $this->sut->parse($jsonResponse);
    }
}

