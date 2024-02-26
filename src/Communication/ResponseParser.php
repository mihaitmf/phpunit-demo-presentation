<?php

namespace Demo\Communication;

class ResponseParser
{
    const SUCCESS_RESPONSE_STATUS = 'ok';
    const ERROR_RESPONSE_STATUS = 'fail';

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
     * Only for the success case, populate the Response object "reference" property with the value from
     * the json "id" field following the rule:
     *      - for even "id" values, set the value divided by 2; ex: id = 100  ->  reference = 50.
     *      - for odd "id" values, set the same value; ex: id = 101  ->  reference = 101.
     *
     * @param string $jsonResponse
     *
     * @return Response
     * @throws \Exception
     */
    public function parse($jsonResponse)
    {
        $responseArray = json_decode($jsonResponse, true);

        if ($responseArray['status'] === self::SUCCESS_RESPONSE_STATUS) {
            return $this->buildSuccessResponse($responseArray);

        } elseif ($responseArray['status'] === self::ERROR_RESPONSE_STATUS) {
            return Response::error()
                ->withMessage('ERROR - ' . $responseArray['reason']);
        }

        throw new \Exception("Invalid response status: {$responseArray['status']}");
    }

    /**
     * @param $responseArray
     *
     * @return Response
     */
    private function buildSuccessResponse($responseArray): Response
    {
        $ref = (int)$responseArray['id'];

        if ($ref % 2 === 0) {
            $ref /= 2;
        }

        return Response::success()
            ->withMessage($responseArray['reason'])
            ->withReference($ref);
    }
}
