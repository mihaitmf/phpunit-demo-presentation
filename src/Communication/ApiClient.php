<?php

namespace Demo\Communication;

class ApiClient
{
    /** @var HttpClient */
    private $httpClient;

    /** @var ResponseParser */
    private $responseParser;

    public function __construct(HttpClient $httpClient, ResponseParser $responseParser)
    {
        $this->httpClient = $httpClient;
        $this->responseParser = $responseParser;
    }

    /**
     * @param array $requestArray
     *
     * @return Response
     * @throws \Exception
     */
    public function callApi(array $requestArray)
    {
        $jsonResponse = $this->httpClient->makeHttpRequest($requestArray);

        return $this->responseParser->parse($jsonResponse);
    }
}
