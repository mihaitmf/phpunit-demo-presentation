<?php

namespace Demo\Communication;

class ResponseParser
{
    /**
     * Creates a Response object from a json string.
     *
     * Example success json response:
     * {"status":"ok","reason":"Success message","id":1234,"extra":"some details"}
     *
     * A "success" Response object is returned when the json contains "status" = "ok".
     * The Response "message" is the json field "reason".
     *
     * Example error json response:
     * {"status":"fail","reason":"An error occurred because...","id":1234,"extra":"some details"}
     *
     * An "error" Response object is returned when the json contains "status" = "fail".
     * The Response "message" is the json field "reason" prefixed with "ERROR - ".
     *
     * ADDITIONAL REQUIREMENT
     * Populate the Response object "reference" property with the value from the json "id" field following the rule:
     *      - for even "id" values, set the value divided by 2; ex: id = 100  ->  reference = 50.
     *      - for odd "id" values, set the same value; ex: id = 100  ->  reference = 100.
     *
     * @param string $jsonResponse
     *
     * @return Response
     * @throws \Exception
     */
    public function parse($jsonResponse)
    {
        $responseArray = json_decode($jsonResponse, true);

        if ($responseArray['status'] === 'ok') {
            return Response::success()
                ->withMessage($responseArray['reason']);

        } elseif ($responseArray['status'] === 'fail') {
            return Response::error()
                ->withMessage('ERROR - ' . $responseArray['reason']);
        }

        throw new \Exception("Invalid response status: {$responseArray['status']}");
    }
}
