Codice Fiscale PHP [![Build Status](https://app.travis-ci.com/nigrosimone/codice-fiscale.svg?branch=master)](https://app.travis-ci.com/nigrosimone/codice-fiscale) [![Coverage Status](https://coveralls.io/repos/github/nigrosimone/CodiceFiscale/badge.svg?branch=master)](https://coveralls.io/github/nigrosimone/CodiceFiscale?branch=master)
=============

Libreria PHP per la validazione dei Codici Fiscali italiani a 16 caratteri con supporto per l'omocodia. Leggera (solo 10 KB) e veloce (1'000'000 di codici fiscali validati in 3 secondi).

## Installazione
Usa il dependancy mananger composer per installare `nigrosimone/codicefiscale`:
```bash
composer require nigrosimone/codicefiscale
```
Oppure scarica direttamente il sorgente [CodiceFiscale.php](https://github.com/nigrosimone/codice-fiscale/blob/master/src/CodiceFiscale.php)

## Uso

```php
<?php
require "vendor/autoload.php";

use NigroSimone\CodiceFiscale;

$cf = new CodiceFiscale();

if( $cf->validaCodiceFiscale('MRARSS75P14H501I') )
    echo 'Codice fiscale corretto';
else
    echo 'Codice fiscale non corretto';
```

Demo [online](https://phpsandbox.io/e/x/h1r2e)

## Sviluppo

Clona il progetto:
```bash
git clone https://github.com/nigrosimone/CodiceFiscale.git
```

Per inizializzare il progetto:
```bash
composer install
```

Per eseguire i test unitari:
```bash
composer test
```

Per eseguire il lint:
```bash
composer phpcs
```

Per visualizzare l'esempio (`Esempio.php`):
```bash
composer dev
```
l'esempio sarà visibile l'indirizzo http://localhost:8000
