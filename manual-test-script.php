<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php";

use Demo\Communication\ResponseParser;

$successJsonResponse = '{"status":"ok","reason":"Success message","id":1234,"extra":"some details"}';
$errorJsonResponse = '{"status":"fail","reason":"Invalid response","id":1234,"extra":"some details"}';

$responseParser = new ResponseParser();

$result = $responseParser->parse($successJsonResponse);

var_dump($result);
