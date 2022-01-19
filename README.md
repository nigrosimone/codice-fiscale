CodiceFiscale
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
php ./vendor/bin/phpunit
```

Per visualizzare l'esempio:
```bash
php -S localhost:8000 Esempio.php
```
