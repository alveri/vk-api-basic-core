<?php

namespace App\Common\DTO;

class HttpEvent
{

    /**
     * @var array
     */
    public array $headers;

    /**
     * @var string
     */
    public string $body;

    /**
     * @var string
     */
    public string $query;

    public function __construct(array $headers, string $body, string $query)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->body = $body;
        $this->query = $query;
    }
}
