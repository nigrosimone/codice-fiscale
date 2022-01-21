Codice Fiscale
=============

Classe PHP per la validazione dei Codici Fiscali italiani a 16 caratteri

## Installazione
Usa il dependancy mananger composer per installare `nigrosimone/codicefiscale`:
```bash
composer require nigrosimone/codicefiscale:dev-master
```

## Uso

```php
<?php
require "vendor/autoload.php";

use NigroSimone\CodiceFiscale;

$cf = new CodiceFiscale();

if( $cf->ValidaCodiceFiscale('MRARSS75P14H501I') )
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

Per visualizzare l'esempio (`Esempio.php`):
```bash
composer dev
```
l'esempio sarà visibile l'indirizzo http://localhost:8000
