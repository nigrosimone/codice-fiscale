CodiceFiscale
=============

Classe PHP per la validazione dei Codici Fiscali italiani a 16 caratteri

Esempio di utilizzo

```php
<?php
require 'CodiceFiscale.php';

$cf = new CodiceFiscale();

if( $cf->ValidaCodiceFiscale('MRARSS75P14H501I') )
    echo 'Codice fiscale corretto';
else
    echo 'Codice fiscale non corretto';
```

Per inizializzare il progetto:
```
composer install
```

Per eseguire i test unitari:
```
./vendor/bin/phpunit
```

