<?php

declare(strict_types=1);

namespace PhpCfdi\CsfPdfScraper\Contracts;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Panther\Cookie\CookieJar;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

interface BrowserClientInterface
{
    public function get($url);
    /**
     * @throws TimeoutException
     * @throws NoSuchElementException
     */
    public function waitFor(string $locator, int $timeoutInSecond = 30, int $intervalInMillisecond = 250);
    public function getCrawler(): Crawler;
    public function submit(Form $form, array $values = [], array $serverParameters = []): DomCrawler;
    public function getCookieJar(): CookieJar;
}
