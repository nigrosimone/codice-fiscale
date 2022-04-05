<?php
namespace NigroSimone;

/**
 * Classe per la validazione dei Codici fiscali
 *
 * @author SimoneNigro
 * @link https://github.com/nigrosimone/
 */
class CodiceFiscale
{

    // Espressione regolare per il controllo formale del codice fiscale
    const REGEX_CODICEFISCALE = '/^[a-z]{6}[0-9]{2}[a-z][0-9]{2}[a-z][0-9]{3}[a-z]$/i';

    // Carattere utilizzato per le donne
    const CHAR_FEMMINA = "F";

    // Carattere utilizzato per gli uomini
    const CHAR_MASCHIO = "M";

    /**
     * Validità del codice fiscale
     *
     * @var bool
     */
    private $isValido = false;

    /**
     * Sesso del codice fiscale
     *
     * @var string
     */
    private $sesso = null;

    /**
     * Comune di nascita del codice fiscale
     *
     * @var string
     */
    private $comuneNascita = null;

    /**
     * Giorno di nascita del codice fiscale
     *
     * @var string
     */
    private $giornoNascita = null;

    /**
     * Mese di nascita del codice fiscale
     *
     * @var string
     */
    private $meseNascita = null;

    /**
     * Anno di nascita del codice fiscale
     *
     * @var string
     */
    private $annoNascita = null;

    /**
     * Primo errore generato nel processo di validazione
     *
     * @var string
     */
    private $errore = null;

    /**
     * Lista sostituzioni per omocodia
     *
     * @var array
     */
    private $listaDecOmocodia = [
        "A" => "!",
        "B" => "!",
        "C" => "!",
        "D" => "!",
        "E" => "!",
        "F" => "!",
        "G" => "!",
        "H" => "!",
        "I" => "!",
        "J" => "!",
        "K" => "!",
        "L" => "0",
        "M" => "1",
        "N" => "2",
        "O" => "!",
        "P" => "3",
        "Q" => "4",
        "R" => "5",
        "S" => "6",
        "T" => "7",
        "U" => "8",
        "V" => "9",
        "W" => "!",
        "X" => "!",
        "Y" => "!",
        "Z" => "!"
    ];

    /**
     * Posizioni caratteri interessati ad alterazione di codifica in caso di omocodia
     *
     * @var array
     */
    private $listaSostOmocodia = [
        6,
        7,
        9,
        10,
        12,
        13,
        14
    ];

    /**
     * Lista peso caratteri PARI
     *
     * @var array
     */
    private $listaCaratteriPari = [
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
     *
     * @var array
     */
    private $listaCaratteriDispari = [
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
     * Lista calcolo codice CONTOLLO (carattere 16)
     *
     * @var array
     */
    private $listaCodiceControllo = [
        0 => "A",
        1 => "B",
        2 => "C",
        3 => "D",
        4 => "E",
        5 => "F",
        6 => "G",
        7 => "H",
        8 => "I",
        9 => "J",
        10 => "K",
        11 => "L",
        12 => "M",
        13 => "N",
        14 => "O",
        15 => "P",
        16 => "Q",
        17 => "R",
        18 => "S",
        19 => "T",
        20 => "U",
        21 => "V",
        22 => "W",
        23 => "X",
        24 => "Y",
        25 => "Z"
    ];

    /**
     * Array per il calcolo del mese
     *
     * @var array
     */
    private $listaDecMesi = [
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
     * Lista messaggi di Errore
     *
     * @var array
     */
    private $listaErrori = [
        0 => "Codice da analizzare assente",
        1 => "Lunghezza codice da analizzare non corretta",
        2 => "Il codice da analizzare contiene caratteri non corretti",
        3 => "Carattere non valido in decodifica omocodia",
        4 => "Codice fiscale non corretto"
    ];

    /**
     * Torna true se il Codice Fiscale è valido
     *
     * @return boolean
     */
    public function getIsValido()
    {
        return $this->isValido;
    }

    /**
     * Torna l'ultimo errore se presente
     *
     * @return string
     */
    public function getErrore()
    {
        return $this->errore;
    }

    /**
     * Torna il sesso del Codice Fiscale
     *
     * @return string
     */
    public function getSesso()
    {
        return $this->sesso;
    }

    /**
     * Torna il comune di nascita del Codice Fiscale
     *
     * @return string
     */
    public function getComuneNascita()
    {
        return $this->comuneNascita;
    }

    /**
     * Torna l'anno di nascita del Codice Fiscale
     *
     * @return string
     */
    public function getAnnoNascita()
    {
        return $this->annoNascita;
    }

    /**
     * Torna il mese di nascita del Codice Fiscale
     *
     * @return string
     */
    public function getMeseNascita()
    {
        return $this->meseNascita;
    }

    /**
     * Torna il giorno di nascita del Codice Fiscale
     *
     * @return string
     */
    public function getGiornoNascita()
    {
        return $this->giornoNascita;
    }

    /**
     * Valida il Codice Fiscale
     *
     * @param string $codiceFiscale
     * @return boolean
     */
    public function validaCodiceFiscale($codiceFiscale)
    {
        $this->resettaProprieta();

        try {
            // Verifico che il Codice Fiscale sia valorizzato
            if (empty($codiceFiscale)) {
                $this->raiseException(0);
            }

            // Verifico che la lunghezza sia almeno di 16 caratteri
            if (strlen($codiceFiscale) !== 16) {
                $this->raiseException(1);
            }

            // Converto in maiuscolo
            $codiceFiscale = strtoupper($codiceFiscale);

            // Converto la stringa in array
            $codiceFiscaleArray = str_split($codiceFiscale);

            // Verifica la correttezza delle alterazioni per omocodia
            for ($i = 0; $i < count($this->listaSostOmocodia); $i ++) {
                if (! is_numeric($codiceFiscaleArray[$this->listaSostOmocodia[$i]])) {
                    if ($this->listaDecOmocodia[$codiceFiscaleArray[$this->listaSostOmocodia[$i]]] === "!") {
                        $this->raiseException(3);
                    }
                }
            }

            $pari = 0;
            $dispari = $this->listaCaratteriDispari[$codiceFiscaleArray[14]];

            // Giro sui primi 14 elementi a passo due
            for ($i = 0; $i < 13; $i += 2) {
                $dispari = $dispari + $this->listaCaratteriDispari[$codiceFiscaleArray[$i]];
                $pari = $pari + $this->listaCaratteriPari[$codiceFiscaleArray[$i + 1]];
            }

            // Verifica congruenza dei valori calcolati sui primi 15 caratteri, con il codice di controllo (carattere 16)
            if (! ($this->listaCodiceControllo[($pari + $dispari) % 26] === $codiceFiscaleArray[15])) {
                $this->raiseException(4);
            }

            // Sostituzione per risolvere eventuali omocodie
            for ($i = 0; $i < count($this->listaSostOmocodia); $i ++) {
                if (! is_numeric($codiceFiscaleArray[$this->listaSostOmocodia[$i]])) {
                    $codiceFiscaleArray[$this->listaSostOmocodia[$i]] = $this->listaDecOmocodia[$codiceFiscaleArray[$this->listaSostOmocodia[$i]]];
                }
            }

            // Converto l'array in stringa
            $codiceFiscaleAdattato = implode($codiceFiscaleArray);

            // Controllo che la forma sia corretta
            if (! preg_match(self::REGEX_CODICEFISCALE, $codiceFiscaleAdattato)) {
                $this->raiseException(2);
            }

            // Estraggo i dati
            $this->sesso = (int) (substr($codiceFiscaleAdattato, 9, 2) > 40) ? self::CHAR_FEMMINA : self::CHAR_MASCHIO;
            $this->comuneNascita = substr($codiceFiscaleAdattato, 11, 4);
            $this->annoNascita = substr($codiceFiscaleAdattato, 6, 2);
            $this->giornoNascita = substr($codiceFiscaleAdattato, 9, 2);
            $this->meseNascita = $this->listaDecMesi[substr($codiceFiscaleAdattato, 8, 1)];

            // Recupero giorno di nascita se Sesso=F
            if ($this->sesso == self::CHAR_FEMMINA) {
                $this->giornoNascita = $this->giornoNascita - 40;

                if (strlen($this->giornoNascita) === 1) {
                    $this->giornoNascita = "0" . $this->giornoNascita;
                }
            }

            // Controlli teminati
            $this->isValido = true;
            $this->errore = null;
        } catch (\Exception $e) {
            $this->errore = $e->getMessage();
            $this->isValido = false;
        }

        return $this->isValido;
    }

    /**
     * Resetta le proprietà della classe
     *
     * @return void
     */
    private function resettaProprieta()
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
     * Alza un'eccezione
     *
     * @param integer $errorNumber
     * @throws \Exception
     * @return void
     */
    private function raiseException($errorNumber)
    {
        $errMessage = isset($this->listaErrori[$errorNumber]) ? $this->listaErrori[$errorNumber] : "Eccezione non gestita";
        throw new \Exception($errMessage, $errorNumber);
    }
}
