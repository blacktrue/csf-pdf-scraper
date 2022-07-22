<?php

declare(strict_types=1);

namespace PhpCfdi\CsfPdfScraper;

use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Cookie\SetCookie;
use Symfony\Component\BrowserKit\CookieJar;
use GuzzleHttp\Cookie\CookieJar as GuzzleCookieJar;

class CookieParser
{
    /** @var CookieJar */
    protected $browserCookieJar;

    public function __construct(CookieJar $browserCookieJar)
    {
        $this->browserCookieJar = $browserCookieJar;
    }

    public function guzzleCookieJar(): CookieJarInterface
    {
        $cookieJar = new GuzzleCookieJar();

        foreach ($this->browserCookieJar->all() as $cookie) {
            $cookieJar->setCookie(
                new SetCookie([
                    'Name' => $cookie->getName(),
                    'Value' => $cookie->getValue(),
                    'Domain' => $cookie->getDomain(),
                ])
            );
        }

        return $cookieJar;
    }
}

