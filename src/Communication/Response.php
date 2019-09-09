<?php

namespace Demo\Communication;

class Response
{
    /** @var bool */
    private $isSuccessful;

    /** @var string */
    private $message;

    /** @var int */
    private $reference;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function success()
    {
        $response = new static();
        $response->isSuccessful = true;

        return $response;
    }

    /**
     * @return static
     */
    public static function error()
    {
        $response = new static();
        $response->isSuccessful = false;

        return $response;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->isSuccessful;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Response
     */
    public function withMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     * @return Response
     */
    public function withReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }
}

