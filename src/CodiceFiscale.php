<?php
declare(strict_types = 1);

namespace NigroSimone;

/**
 * Classe per la validazione dei Codici fiscali
 *
 * @author SimoneNigro
 * @link https://github.com/nigrosimone/
 */
class CodiceFiscale
{

    /**
     * Espressione regolare per il controllo formale del codice fiscale.
     *
     * Le posizioni numeriche (anno, giorno e le ultime tre cifre del comune) accettano
     * anche le lettere previste dall'alterazione per omocodia (L, M, N, P, Q, R, S, T, U, V),
     * mentre il mese e' limitato alle dodici lettere effettivamente in uso.
     * Il controllo viene eseguito PRIMA di ogni accesso alle tabelle di decodifica,
     * in modo che nessun carattere estraneo possa raggiungerle.
     *
     * La regex ammette una lettera di omocodia in ognuna delle sette posizioni in
     * modo indipendente: che le sostituzioni siano contigue e allineate a destra
     * e' verificato a parte, in fase di decodifica.
     */
    private const REGEX_CODICEFISCALE =
        '/^[A-Z]{6}[0-9LMNPQRSTUV]{2}[ABCDEHLMPRST][0-9LMNPQRSTUV]{2}[A-Z][0-9LMNPQRSTUV]{3}[A-Z]$/';

    // Lunghezza del codice fiscale
    private const LUNGHEZZA_CODICEFISCALE = 16;

    // Carattere utilizzato per le donne
    private const CHAR_FEMMINA = "F";

    // Carattere utilizzato per gli uomini
    private const CHAR_MASCHIO = "M";

    // Valore sommato al giorno di nascita per i codici fiscali femminili
    private const OFFSET_FEMMINA = 40;

    /**
     * Lista sostituzioni per omocodia.
     *
     * Contiene le sole lettere ammesse: le cifre e i caratteri non validi sono gia'
     * stati esclusi dal controllo formale, quindi un isset() basta a distinguerle.
     */
    private const LISTA_DEC_OMOCODIA = [
        "L" => "0",
        "M" => "1",
        "N" => "2",
        "P" => "3",
        "Q" => "4",
        "R" => "5",
        "S" => "6",
        "T" => "7",
        "U" => "8",
        "V" => "9"
    ];

    /**
     * Posizioni dei caratteri numerici interessati dall'alterazione per omocodia,
     * elencate DA DESTRA A SINISTRA.
     *
     * L'ordine e' significativo: la sostituzione parte dalla cifra piu' a destra e
     * procede verso sinistra senza salti, quindi le posizioni alterate sono sempre
     * un prefisso di questa lista. Percorrerla in quest'ordine permette di
     * verificare la regola in un solo passaggio.
     */
    private const LISTA_SOST_OMOCODIA = [
        14,
        13,
        12,
        10,
        9,
        7,
        6
    ];

    /**
     * Lista peso caratteri PARI
     */
    private const LISTA_CARATTERI_PARI = [
        "0" => 0,
        "1" => 1,
        "2" => 2,
        "3" => 3,
        "4" => 4,
        "5" => 5,
        "6" => 6,
        "7" => 7,
        "8" => 8,
        "9" => 9,
        "A" => 0,
        "B" => 1,
        "C" => 2,
        "D" => 3,
        "E" => 4,
        "F" => 5,
        "G" => 6,
        "H" => 7,
        "I" => 8,
        "J" => 9,
        "K" => 10,
        "L" => 11,
        "M" => 12,
        "N" => 13,
        "O" => 14,
        "P" => 15,
        "Q" => 16,
        "R" => 17,
        "S" => 18,
        "T" => 19,
        "U" => 20,
        "V" => 21,
        "W" => 22,
        "X" => 23,
        "Y" => 24,
        "Z" => 25
    ];

    /**
     * Lista peso caratteri DISPARI
     */
    private const LISTA_CARATTERI_DISPARI = [
        "0" => 1,
        "1" => 0,
        "2" => 5,
        "3" => 7,
        "4" => 9,
        "5" => 13,
        "6" => 15,
        "7" => 17,
        "8" => 19,
        "9" => 21,
        "A" => 1,
        "B" => 0,
        "C" => 5,
        "D" => 7,
        "E" => 9,
        "F" => 13,
        "G" => 15,
        "H" => 17,
        "I" => 19,
        "J" => 21,
        "K" => 2,
        "L" => 4,
        "M" => 18,
        "N" => 20,
        "O" => 11,
        "P" => 3,
        "Q" => 6,
        "R" => 8,
        "S" => 12,
        "T" => 14,
        "U" => 16,
        "V" => 10,
        "W" => 22,
        "X" => 25,
        "Y" => 24,
        "Z" => 23
    ];

    /**
     * Lista calcolo codice CONTROLLO (carattere 16): l'indice e' il resto della divisione per 26
     */
    private const LISTA_CODICE_CONTROLLO = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    /**
     * Array per il calcolo del mese
     */
    private const LISTA_DEC_MESI = [
        "A" => "01",
        "B" => "02",
        "C" => "03",
        "D" => "04",
        "E" => "05",
        "H" => "06",
        "L" => "07",
        "M" => "08",
        "P" => "09",
        "R" => "10",
        "S" => "11",
        "T" => "12"
    ];

    /**
     * Numero massimo di giorni per ogni mese.
     *
     * Febbraio ammette il 29 perche' l'anno di nascita e' espresso su due cifre e
     * il secolo non e' determinabile, quindi la bisestilita' non e' verificabile.
     */
    private const LISTA_GIORNI_MESE = [
        "01" => 31,
        "02" => 29,
        "03" => 31,
        "04" => 30,
        "05" => 31,
        "06" => 30,
        "07" => 31,
        "08" => 31,
        "09" => 30,
        "10" => 31,
        "11" => 30,
        "12" => 31
    ];

    /**
     * Lista messaggi di Errore
     */
    private const LISTA_ERRORI = [
        0 => "Codice da analizzare assente",
        1 => "Lunghezza codice da analizzare non corretta",
        2 => "Il codice da analizzare contiene caratteri non corretti",
        3 => "Alterazione per omocodia non valida",
        4 => "Codice fiscale non corretto",
        5 => "Data di nascita non valida"
    ];

    /**
     * Validità del codice fiscale
     *
     * @var bool
     */
    private bool $isValido = false;

    /**
     * Sesso del codice fiscale
     *
     * @var string|null
     */
    private ?string $sesso = null;

    /**
     * Comune di nascita del codice fiscale
     *
     * @var string|null
     */
    private ?string $comuneNascita = null;

    /**
     * Giorno di nascita del codice fiscale
     *
     * @var string|null
     */
    private ?string $giornoNascita = null;

    /**
     * Mese di nascita del codice fiscale
     *
     * @var string|null
     */
    private ?string $meseNascita = null;

    /**
     * Anno di nascita del codice fiscale
     *
     * @var string|null
     */
    private ?string $annoNascita = null;

    /**
     * Primo errore generato nel processo di validazione
     *
     * @var string|null
     */
    private ?string $errore = null;

    /**
     * Torna true se il Codice Fiscale è valido
     *
     * @return boolean
     */
    public function getIsValido(): bool
    {
        return $this->isValido;
    }

    /**
     * Torna l'ultimo errore se presente
     *
     * @return string|null
     */
    public function getErrore(): ?string
    {
        return $this->errore;
    }

    /**
     * Torna il sesso del Codice Fiscale
     *
     * @return string|null
     */
    public function getSesso(): ?string
    {
        return $this->sesso;
    }

    /**
     * Torna il comune di nascita del Codice Fiscale
     *
     * @return string|null
     */
    public function getComuneNascita(): ?string
    {
        return $this->comuneNascita;
    }

    /**
     * Torna l'anno di nascita del Codice Fiscale
     *
     * @return string|null
     */
    public function getAnnoNascita(): ?string
    {
        return $this->annoNascita;
    }

    /**
     * Torna il mese di nascita del Codice Fiscale
     *
     * @return string|null
     */
    public function getMeseNascita(): ?string
    {
        return $this->meseNascita;
    }

    /**
     * Torna il giorno di nascita del Codice Fiscale
     *
     * @return string|null
     */
    public function getGiornoNascita(): ?string
    {
        return $this->giornoNascita;
    }

    /**
     * Valida il Codice Fiscale
     *
     * @param string $codiceFiscale
     * @return boolean
     */
    public function validaCodiceFiscale(string $codiceFiscale): bool
    {
        $this->resettaProprieta();

        // Verifico che il Codice Fiscale sia valorizzato
        if ($codiceFiscale === "") {
            return $this->impostaErrore(0);
        }

        // Verifico che la lunghezza sia esattamente di 16 caratteri
        if (\strlen($codiceFiscale) !== self::LUNGHEZZA_CODICEFISCALE) {
            return $this->impostaErrore(1);
        }

        // Converto in maiuscolo
        $codiceFiscale = \strtoupper($codiceFiscale);

        // Controllo che la forma sia corretta: da qui in poi ogni carattere è garantito
        // essere una chiave valida delle tabelle di decodifica
        if (!\preg_match(self::REGEX_CODICEFISCALE, $codiceFiscale)) {
            return $this->impostaErrore(2);
        }

        // Somma dei pesi dei primi 15 caratteri, calcolata sul codice NON normalizzato
        // perché il carattere di controllo è calcolato sulla forma omocodica
        $somma = self::LISTA_CARATTERI_DISPARI[$codiceFiscale[14]];

        // Giro sui primi 14 elementi a passo due
        for ($i = 0; $i < 13; $i += 2) {
            $somma += self::LISTA_CARATTERI_DISPARI[$codiceFiscale[$i]]
                + self::LISTA_CARATTERI_PARI[$codiceFiscale[$i + 1]];
        }

        // Verifica congruenza dei valori calcolati sui primi 15 caratteri, con il codice di controllo (carattere 16)
        if (self::LISTA_CODICE_CONTROLLO[$somma % 26] !== $codiceFiscale[15]) {
            return $this->impostaErrore(4);
        }

        // Sostituzione per risolvere eventuali omocodie.
        // Le posizioni sono percorse da destra a sinistra, lo stesso verso in cui
        // l'Agenzia delle Entrate applica l'alterazione: una volta incontrata una
        // cifra non alterata, nessuna delle posizioni piu' a sinistra puo' essere
        // una lettera, altrimenti il codice non e' emettibile.
        $codiceFiscaleAdattato = $codiceFiscale;
        $attesaCifra = false;
        foreach (self::LISTA_SOST_OMOCODIA as $posizione) {
            $char = $codiceFiscaleAdattato[$posizione];
            if (!isset(self::LISTA_DEC_OMOCODIA[$char])) {
                $attesaCifra = true;
                continue;
            }
            if ($attesaCifra) {
                return $this->impostaErrore(3);
            }
            $codiceFiscaleAdattato[$posizione] = self::LISTA_DEC_OMOCODIA[$char];
        }

        // Estraggo i dati
        $meseNascita = self::LISTA_DEC_MESI[$codiceFiscaleAdattato[8]];
        $giornoNascita = (int) \substr($codiceFiscaleAdattato, 9, 2);
        $sesso = ($giornoNascita > self::OFFSET_FEMMINA) ? self::CHAR_FEMMINA : self::CHAR_MASCHIO;

        // Recupero giorno di nascita se Sesso=F
        if ($sesso === self::CHAR_FEMMINA) {
            $giornoNascita -= self::OFFSET_FEMMINA;
        }

        // Verifico che il giorno sia compatibile con il mese di nascita
        if ($giornoNascita < 1 || $giornoNascita > self::LISTA_GIORNI_MESE[$meseNascita]) {
            return $this->impostaErrore(5);
        }

        $this->meseNascita = $meseNascita;
        $this->giornoNascita = \sprintf("%02d", $giornoNascita);
        $this->sesso = $sesso;
        $this->comuneNascita = \substr($codiceFiscaleAdattato, 11, 4);
        $this->annoNascita = \substr($codiceFiscaleAdattato, 6, 2);

        // Controlli terminati
        $this->isValido = true;
        $this->errore = null;

        return true;
    }

    /**
     * Resetta le proprietà della classe
     *
     * @return void
     */
    private function resettaProprieta(): void
    {
        $this->isValido = false;
        $this->sesso = null;
        $this->comuneNascita = null;
        $this->giornoNascita = null;
        $this->meseNascita = null;
        $this->annoNascita = null;
        $this->errore = null;
    }

    /**
     * Registra l'errore di validazione e torna sempre false
     *
     * @param integer $errorNumber
     * @return boolean
     */
    private function impostaErrore(int $errorNumber): bool
    {
        $this->errore = self::LISTA_ERRORI[$errorNumber] ?? "Eccezione non gestita";
        $this->isValido = false;

        return false;
    }
}
