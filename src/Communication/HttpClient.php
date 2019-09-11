<?php

namespace Demo\Communication;

class HttpClient
{
    /**
     * @param array $requestParams
     *
     * @return string
     */
    public function makeHttpRequest(array $requestParams)
    {
        print("I am doing the actual HTTP request, maybe you should mock me");

        return '{"status":"ok","reason":"Success message","id":1234,"extra":"some details"}';
    }
}
