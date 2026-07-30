# Codice Fiscale PHP

[![CI](https://github.com/nigrosimone/codice-fiscale/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/nigrosimone/codice-fiscale/actions/workflows/ci.yml) [![Coverage Status](https://coveralls.io/repos/github/nigrosimone/codice-fiscale/badge.svg?branch=master)](https://coveralls.io/github/nigrosimone/codice-fiscale?branch=master)

Libreria PHP per la validazione dei Codici Fiscali italiani a 16 caratteri con supporto per l'omocodia. Leggera (solo 10 KB) e veloce (1'000'000 di codici fiscali validati in 3 secondi).

Oltre al carattere di controllo vengono verificati la forma del codice, il mese di nascita e la
compatibilità del giorno con il mese. Le terne di cognome e nome sono validate nella struttura:
si costruiscono prendendo le consonanti nell'ordine, poi le vocali nell'ordine, riempiendo con `X`
se le lettere disponibili sono meno di tre, quindi una vocale non può essere seguita da una
consonante diversa dalla `X`. Sono ammesse 12.251 terne su 17.576, cioè meno della metà dei
prefissi di sei lettere. Del codice catastale viene controllata la lettera iniziale,
limitata a quelle realmente assegnate (`A`-`M` per i comuni italiani, dove l'alfabeto italiano non
comprende `J` e `K`, e `Z` per gli stati esteri), mentre le tre cifre successive non sono
confrontate con l'elenco ANCI: un codice `valido` è formalmente coerente, non necessariamente
esistente.

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

### Validazione del codice catastale

Le tre cifre del codice catastale non sono verificate: servirebbe l'elenco completo, e
`setValidatoreComune()` permette di innestarlo senza appesantire la libreria. Il callable riceve
il codice di 4 caratteri già risolto da eventuale omocodia e torna `true` se esiste:

```php
$comuni = ['H501', 'F205', 'L219', 'Z133']; // il tuo elenco

$cf = new CodiceFiscale();
$cf->setValidatoreComune(function (string $comune) use ($comuni): bool {
    return in_array($comune, $comuni, true);
});

$cf->validaCodiceFiscale('MRARSS75P14H501I'); // true
$cf->validaCodiceFiscale('MRARSS75P14A999N'); // false, "Codice del comune non valido"
```

Il validatore è invocato per ultimo, solo sui codici che hanno superato tutti gli altri
controlli, e si rimuove passando `null`.

> **Attenzione all'elenco che usi.** Il [CSV ISTAT dei comuni](https://www.istat.it/it/archivio/6789)
> contiene i soli comuni **attivi**: usarlo da solo farebbe rifiutare i codici fiscali di chi è
> nato in un comune poi soppresso, e sono circa 2.500 codici catastali su 10.400 mai assegnati.
> Serve l'elenco completo dell'[Archivio Comuni e Stati Esteri](https://www.agenziaentrate.gov.it/portale/schede/fabbricatiterreni/archivio-comuni-e-stati-esteri/consultazione-archivio-comuni-stati-esteri)
> dell'Agenzia delle Entrate, che comprende i comuni soppressi e gli stati esteri (codici `Z`).

## Sviluppo

Clona il progetto:

```bash
git clone https://github.com/nigrosimone/codice-fiscale.git
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
