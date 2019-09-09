<?php

namespace Demo\Communication;

class ResponseParser
{
    const ERROR_RESPONSE_STATUS = 'fail';
    const SUCCESS_RESPONSE_STATUS = 'ok';

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
     * @param string $jsonResponse
     *
     * @return Response
     * @throws \Exception
     */
    public function parse($jsonResponse)
    {
        $responseArray = json_decode($jsonResponse, true);

        if ($responseArray['status'] === self::SUCCESS_RESPONSE_STATUS) {
            $id = $responseArray['id'];

            if ($id % 2 === 0) {
                $reference = $id / 2;
            } else {
                $reference = $id;
            }

            return Response::success()
                ->withMessage($responseArray['reason'])
                ->withReference($reference);

        } elseif ($responseArray['status'] === self::ERROR_RESPONSE_STATUS) {
            return Response::error()
                ->withMessage('ERROR - ' . $responseArray['reason'])
                ->withReference($responseArray['id']);
        }

        throw new \Exception("Invalid response status: {$responseArray['status']}");
    }
}
