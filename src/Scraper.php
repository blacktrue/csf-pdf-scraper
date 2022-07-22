<?php

declare(strict_types=1);

namespace PhpCfdi\CsfPdfScraper;

use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\WebDriver;
use GuzzleHttp\Client;
use PhpCfdi\CsfPdfScraper\Exceptions\InvalidCaptchaException;
use PhpCfdi\CsfPdfScraper\Exceptions\InvalidCredentialsException;
use PhpCfdi\CsfPdfScraper\Exceptions\PDFDownloadException;
use PhpCfdi\CsfPdfScraper\Exceptions\SatScraperException;
use PhpCfdi\ImageCaptchaResolver\CaptchaImage;
use PhpCfdi\ImageCaptchaResolver\CaptchaResolverInterface;

class Scraper
{
    public function __construct(
        private Credentials $credentials,
        private CaptchaResolverInterface $captchaResolver,
        private WebDriver $webDriver,
        private Client $client,
        private int $timeout = 30
    ) {
    }

    /**
     * @throws InvalidCaptchaException
     * @throws InvalidCredentialsException
     */
    private function login(): void
    {
        $this->webDriver->get(URL::LOGIN_URL);
        try {
            $this->webDriver->waitFor('#divCaptcha', $this->timeout);
        } catch (TimeoutException $exception) {
            throw new SatScraperException(sprintf('The %s page does not load as expected', URL::LOGIN_URL), 0, $exception);
        }

        $captcha = $this->webDriver->getCrawler()
            ->filter('#divCaptcha > img')
            ->first();

        $image = CaptchaImage::newFromInlineHtml($captcha->attr('src'));

        $value = $this->captchaResolver->resolve($image);

        $form = $this->webDriver->getCrawler()
            ->selectButton('submit')
            ->form();

        $form->setValues([
            'Ecom_User_ID' => $this->credentials->getRfc(),
            'Ecom_Password' => $this->credentials->getCiec(),
            'userCaptcha' => $value->getValue(),
        ]);

        $this->webDriver->submit($form);

        $html = $this->webDriver->getCrawler()->html();
        if (str_contains($html, 'Captcha no válido')) {
            throw new InvalidCaptchaException('The provided captcha is invalid');
        }

        if (str_contains($html, 'El RFC o contraseña son incorrectos')) {
            throw new InvalidCredentialsException('The provided credentials are invalid');
        }
    }

    private function buildConstancia(): void
    {
        $this->webDriver->get(URL::MAIN_URL);
        try {
            $this->webDriver->waitFor('#idPanelReimpAcuse_header', $this->timeout);
        } catch (TimeoutException $exception) {
            throw new SatScraperException(sprintf('The %s page does not load as expected', URL::MAIN_URL), 0, $exception);
        }

        $form = $this->webDriver->getCrawler()
            ->selectButton('Generar Constancia')
            ->form();

        $this->webDriver->submit($form);
    }

    private function logout(): void
    {
        $this->webDriver->get(URL::LOGOUT_URL);
        $this->webDriver->waitFor('#campo-busqueda', $this->timeout);
        $this->webDriver->getCrawler()
            ->selectButton('Cerrar sesión')
            ->click();
    }

    public function download(): string
    {
        $this->login();
        $this->buildConstancia();

        $cookieParser = new CookieParser($this->webDriver->getCookieJar());

        try {
            $response = $this->client->request('GET',
                URL::DOWNLOAD_CONSTANCIA_URL, [
                    'cookies' => $cookieParser->guzzleCookieJar(),
                ]);
        } catch (\Throwable $exception) {
            throw new PDFDownloadException('Error getting pdf, server error', 0, $exception);
        }

        // TODO: quitar esta linea cuando ya no lo descargue 2 veces
        @unlink('SAT.pdf');

        // TODO: hacer logout correctamente
        // $this->logout();*/

        return $response->getBody()->__toString();
    }
}
