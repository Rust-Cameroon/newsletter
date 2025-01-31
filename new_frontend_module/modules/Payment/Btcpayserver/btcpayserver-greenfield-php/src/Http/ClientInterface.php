<?php

declare(strict_types=1);

namespace BTCPayServer\Http;

use BTCPayServer\Exception\ConnectException;
use BTCPayServer\Exception\RequestException;

interface ClientInterface
{
    /**
     * Sends the HTTP request to API server.
     *
     *
     * @throws ConnectException
     * @throws RequestException
     */
    public function request(string $method, string $url, array $headers = [], string $body = ''): ResponseInterface;
}
