<?php

namespace Demo\Communication;

class ApiClient
{
    /**
     * @param array $requestArray
     *
     * @return Response
     * @throws \Exception
     */
    public function callApi(array $requestArray)
    {
        $httpClient = new HttpClient();
        $jsonResponse = $httpClient->makeHttpRequest($requestArray);

        $responseParser = new ResponseParser();

        return $responseParser->parse($jsonResponse);
    }
}
