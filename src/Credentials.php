<?php

declare(strict_types=1);

namespace PhpCfdi\CsfPdfScraper;

class Credentials
{
    public function __construct(private string $rfc, private string $ciec)
    {
    }

    public function getRfc(): string
    {
        return $this->rfc;
    }

    public function getCiec(): string
    {
        return $this->ciec;
    }
}
