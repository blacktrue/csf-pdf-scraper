# phpcfdi/csf-pdf-scraper

[![Source Code][badge-source]][source]
[![Packagist PHP Version Support][badge-php-version]][php-version]
[![Discord][badge-discord]][discord]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Reliability][badge-reliability]][reliability]
[![Maintainability][badge-maintainability]][maintainability]
[![Code Coverage][badge-coverage]][coverage]
[![Violations][badge-violations]][violations]
[![Total Downloads][badge-downloads]][downloads]

> Obtiene la constancia fiscal actual de una persona moral o física con RFC y CIEC.

:us: The documentation of this project is in spanish as this is the natural language for intended audience.

:mexico: La documentación del proyecto está en español porque ese es el lenguaje principal de los usuarios.

## Instalación

Usa [composer](https://getcomposer.org/)

```php
composer require phpcfdi/csf-pdf-scraper
```

Esta librería hace uso WebDriver y tienes dos opciones para elegir: ChromeDriver y geckodriver. Puedes usar los comandos a continuación para instalarlos:

```shell
composer require --dev dbrekelmans/bdi
vendor/bin/bdi detect drivers
```
Por default, el cliente buscará el webdriver en el directorio `drivers/` del proyecto.

Para más información ver la [guía de instalación](https://github.com/symfony/panther#installing-chromedriver-and-geckodriver)

### Ejemplo de uso

```php
<?php

declare(strict_types=1);

require "vendor/autoload.php";

use PhpCfdi\CsfPdfScraper\Credentials;
use PhpCfdi\CsfPdfScraper\Scraper;
use PhpCfdi\ImageCaptchaResolver\Resolvers\ConsoleResolver;
use Symfony\Component\Panther\Client;
use PhpCfdi\CsfPdfScraper\PantherBrowserClient;

$chromeClient = Client::createChromeClient();
$client = new PantherBrowserClient($chromeClient);
$http = new \GuzzleHttp\Client();
$resolver = new ConsoleResolver();
$credentials = new Credentials('XAXX010101000', 'clave-ciec');

$scraper = new Scraper($credentials, $resolver, $client, $http);
$pdfContents = $scraper->download();
file_put_contents('./constancia.pdf', $pdfContents);
```

## Soporte

Puedes obtener soporte abriendo un ticket en Github.

Adicionalmente, esta librería pertenece a la comunidad [PhpCfdi](https://www.phpcfdi.com), así que puedes usar los
mismos canales de comunicación para obtener ayuda de algún miembro de la comunidad.

## Compatibilidad

Esta librería se mantendrá compatible con al menos la versión con
[soporte activo de PHP](https://www.php.net/supported-versions.php) más reciente.

También utilizamos [Versionado Semántico 2.0.0](docs/SEMVER.md) por lo que puedes usar esta librería
sin temor a romper tu aplicación.

## Contribuciones

Las contribuciones con bienvenidas. Por favor lee [CONTRIBUTING][] para más detalles
y recuerda revisar el archivo de tareas pendientes [TODO][] y el archivo [CHANGELOG][].

## Copyright and License

The `phpcfdi/csf-pdf-scraper` library is copyright © [PhpCfdi](https://www.phpcfdi.com/)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.

[contributing]: https://github.com/phpcfdi/csf-pdf-scraper/blob/main/CONTRIBUTING.md
[changelog]: https://github.com/phpcfdi/csf-pdf-scraper/blob/main/docs/CHANGELOG.md
[todo]: https://github.com/phpcfdi/csf-pdf-scraper/blob/main/docs/TODO.md

[source]: https://github.com/phpcfdi/csf-pdf-scraper
[php-version]: https://packagist.org/packages/phpcfdi/csf-pdf-scraper
[discord]: https://discord.gg/aFGYXvX
[release]: https://github.com/phpcfdi/csf-pdf-scraper/releases
[license]: https://github.com/phpcfdi/csf-pdf-scraper/blob/main/LICENSE
[build]: https://github.com/phpcfdi/csf-pdf-scraper/actions/workflows/build.yml?query=branch:main
[reliability]:https://sonarcloud.io/component_measures?id=phpcfdi_csf-pdf-scraper&metric=Reliability
[maintainability]: https://sonarcloud.io/component_measures?id=phpcfdi_csf-pdf-scraper&metric=Maintainability
[coverage]: https://sonarcloud.io/component_measures?id=phpcfdi_csf-pdf-scraper&metric=Coverage
[violations]: https://sonarcloud.io/project/issues?id=phpcfdi_csf-pdf-scraper&resolved=false
[downloads]: https://packagist.org/packages/phpcfdi/csf-pdf-scraper

[badge-source]: https://img.shields.io/badge/source-phpcfdi/csf--scraper-blue.svg?logo=github
[badge-php-version]: https://img.shields.io/packagist/php-v/phpcfdi/csf-pdf-scraper?logo=php
[badge-discord]: https://img.shields.io/discord/459860554090283019?logo=discord
[badge-release]: https://img.shields.io/github/release/phpcfdi/csf-pdf-scraper.svg?logo=git
[badge-license]: https://img.shields.io/github/license/phpcfdi/csf-pdf-scraper.svg?logo=open-source-initiative
[badge-build]: https://img.shields.io/github/workflow/status/phpcfdi/csf-pdf-scraper/build/main?logo=github-actions
[badge-reliability]: https://sonarcloud.io/api/project_badges/measure?project=phpcfdi_csf-pdf-scraper&metric=reliability_rating
[badge-maintainability]: https://sonarcloud.io/api/project_badges/measure?project=phpcfdi_csf-pdf-scraper&metric=sqale_rating
[badge-coverage]: https://img.shields.io/sonar/coverage/phpcfdi_csf-pdf-scraper/main?logo=sonarcloud&server=https%3A%2F%2Fsonarcloud.io
[badge-violations]: https://img.shields.io/sonar/violations/phpcfdi_csf-pdf-scraper/main?format=long&logo=sonarcloud&server=https%3A%2F%2Fsonarcloud.io
[badge-downloads]: https://img.shields.io/packagist/dt/phpcfdi/csf-pdf-scraper.svg?logo=packagist
