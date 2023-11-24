<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class HistoryNullResponse implements ResponseInterface
{
    public function getProtocolVersion(): string
    {
        return '';
    }

    public function withProtocolVersion(string $version): MessageInterface
    {
        return $this;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function hasHeader(string $name): bool
    {
        return false;
    }

    public function getHeader(string $name): array
    {
        return [];
    }

    public function getHeaderLine(string $name): string
    {
        return '';
    }

    public function withHeader(string $name, $value): MessageInterface
    {
        return $this;
    }

    public function withAddedHeader(string $name, $value): MessageInterface
    {
        return $this;
    }

    public function withoutHeader(string $name): MessageInterface
    {
        return $this;
    }

    public function getBody(): StreamInterface
    {
        return \GuzzleHttp\Psr7\Utils::streamFor('<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <GetCursDynamicXMLResponse xmlns="http://web.cbr.ru/">
            <GetCursDynamicXMLResult>
            </GetCursDynamicXMLResult>
        </GetCursDynamicXMLResponse>
    </soap:Body>
</soap:Envelope>');
    }

    public function withBody(StreamInterface $body): MessageInterface
    {
        return $this;
    }

    public function getStatusCode(): int
    {
        return 500;
    }

    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        return $this;
    }

    public function getReasonPhrase(): string
    {
        return '';
    }

}
