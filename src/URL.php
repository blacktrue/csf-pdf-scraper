<?php

declare(strict_types=1);

namespace PhpCfdi\CsfPdfScraper;

final class URL
{
    const LOGIN_URL = 'https://login.siat.sat.gob.mx/nidp/saml2/sso';
    CONST LOGOUT_URL = 'https://wwwmat.sat.gob.mx/operacion/53027/genera-tu-constancia-de-situacion-fiscal';
    const MAIN_URL = 'https://rfcampc.siat.sat.gob.mx/app/seg/SessionBroker?url=/PTSC/IdcSiat/autc/ReimpresionTramite/ConsultaTramite.jsf&parametro=c&idSessionBit=&idSessionBit=null';
    const DOWNLOAD_CONSTANCIA_URL = 'https://rfcampc.siat.sat.gob.mx/PTSC/IdcSiat/IdcGeneraConstancia.jsf';
}
