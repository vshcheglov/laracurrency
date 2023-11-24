<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class InfoNullResponse implements ResponseInterface
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
            <ValCurs Date="00.00.0000" name="Foreign Currency Market"></ValCurs>');
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
