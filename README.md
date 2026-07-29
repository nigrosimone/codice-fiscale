# Codice Fiscale PHP

[![CI](https://github.com/nigrosimone/codice-fiscale/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/nigrosimone/codice-fiscale/actions/workflows/ci.yml) [![Coverage Status](https://coveralls.io/repos/github/nigrosimone/CodiceFiscale/badge.svg?branch=master)](https://coveralls.io/github/nigrosimone/CodiceFiscale?branch=master)

Libreria PHP per la validazione dei Codici Fiscali italiani a 16 caratteri con supporto per l'omocodia. Leggera (solo 10 KB) e veloce (1'000'000 di codici fiscali validati in 3 secondi).

Oltre al carattere di controllo vengono verificati la forma del codice, il mese di nascita e la
compatibilità del giorno con il mese. Il codice del comune viene estratto ma non confrontato con
l'elenco ANCI: un codice `valido` è formalmente coerente, non necessariamente esistente.

L'alterazione per omocodia è accettata solo nella forma prevista dal DM 23/12/1976: la
sostituzione delle cifre con le corrispondenti lettere parte dal carattere numerico più a destra
e prosegue verso sinistra senza salti. Un codice in cui una cifra risulta sostituita mentre una
posizione più a destra è rimasta numerica non è emettibile e viene rifiutato, anche quando il
carattere di controllo è corretto.

## Requisiti

PHP 7.4 o superiore (testata fino a PHP 8.4).

## Installazione

Usa il dependency manager composer per installare `nigrosimone/codicefiscale`:

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

l'esempio sarà visibile l'indirizzo <http://localhost:8000>
