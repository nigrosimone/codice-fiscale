<?php
require_once __DIR__ . "/../src/CodiceFiscale.php";
use PHPUnit\Framework\TestCase;
use NigroSimone\CodiceFiscale;

class CodiceFiscaleTest extends TestCase
{

    /**
     *
     * @dataProvider goodDataProvider
     */
    function test_checker_can_detect_omocodia($goodFiscalCode)
    {
        $chk = new CodiceFiscale();

        self::assertTrue(empty($chk->getGiornoNascita()), 'empty getGiornoNascita');
        self::assertTrue(empty($chk->getMeseNascita()), 'empty getMeseNascita');
        self::assertTrue(empty($chk->getAnnoNascita()), 'empty getAnnoNascita');
        self::assertTrue(empty($chk->getComuneNascita()), 'empty getComuneNascita');
        self::assertTrue(empty($chk->getSesso()), 'empty getSesso');
        self::assertTrue(empty($chk->getErrore()), 'not empty getErrore');
        self::assertFalse($chk->getIsValido(), 'getIsValido');

        self::assertTrue($chk->validaCodiceFiscale($goodFiscalCode), $chk->getErrore() ?? "");

        self::assertFalse(empty($chk->getGiornoNascita()), 'empty getGiornoNascita');
        self::assertFalse(empty($chk->getMeseNascita()), 'empty getMeseNascita');
        self::assertFalse(empty($chk->getAnnoNascita()), 'empty getAnnoNascita');
        self::assertFalse(empty($chk->getComuneNascita()), 'empty getComuneNascita');
        self::assertFalse(empty($chk->getSesso()), 'empty getSesso');
        self::assertTrue(empty($chk->getErrore()), 'not empty getErrore');

        self::assertTrue(is_string($chk->getGiornoNascita()), 'is_string getGiornoNascita');
        self::assertTrue(is_string($chk->getMeseNascita()), 'is_string getMeseNascita');
        self::assertTrue(is_string($chk->getAnnoNascita()), 'is_string getAnnoNascita');
        self::assertTrue(is_string($chk->getComuneNascita()), 'is_string getComuneNascita');
        self::assertTrue(is_string($chk->getSesso()), 'is_string getSesso');

        self::assertTrue(strlen($chk->getGiornoNascita()) === 2, 'strlen getGiornoNascita');
        self::assertTrue(strlen($chk->getMeseNascita()) === 2, 'strlen getMeseNascita');
        self::assertTrue(strlen($chk->getAnnoNascita()) === 2, 'strlen getAnnoNascita');
        self::assertTrue(strlen($chk->getComuneNascita()) === 4, 'strlen getComuneNascita');
        self::assertTrue(strlen($chk->getSesso()) === 1, 'strlen getSesso');

        self::assertTrue($chk->getIsValido(), 'getIsValido');
    }

    /**
     *
     * @dataProvider badDataProvider
     */
    function test_checker_can_detect_badCodes($badFiscalCode)
    {
        $chk = new CodiceFiscale();

        self::assertTrue(empty($chk->getGiornoNascita()), 'empty getGiornoNascita');
        self::assertTrue(empty($chk->getMeseNascita()), 'empty getMeseNascita');
        self::assertTrue(empty($chk->getAnnoNascita()), 'empty getAnnoNascita');
        self::assertTrue(empty($chk->getComuneNascita()), 'empty getComuneNascita');
        self::assertTrue(empty($chk->getSesso()), 'empty getSesso');
        self::assertTrue(empty($chk->getErrore()), 'not empty getErrore');
        self::assertFalse($chk->getIsValido(), 'getIsValido');

        self::assertFalse($chk->validaCodiceFiscale($badFiscalCode), $chk->getErrore() ?? "");

        self::assertTrue(empty($chk->getGiornoNascita()), 'not empty getGiornoNascita');
        self::assertTrue(empty($chk->getMeseNascita()), 'not empty getMeseNascita');
        self::assertTrue(empty($chk->getAnnoNascita()), 'not empty getAnnoNascita');
        self::assertTrue(empty($chk->getComuneNascita()), 'not empty getComuneNascita');
        self::assertTrue(empty($chk->getSesso()), 'not empty getSesso');
        self::assertFalse(empty($chk->getErrore()), 'empty getErrore');
        self::assertFalse($chk->getIsValido(), 'getIsValido');
    }

    public function goodDataProvider(): array
    {
        return [
            [
                "DLCFNC01L46H50MJ"
            ],
            [
                "LMRBHM74A01Z3PLX"
            ],
            [
                "CNTPTR60C29H5LMO"
            ],
            [
                "MRARSS75P14H501I"
            ],
            [
                "MRARSS82M56F205J"
            ],
            // Gli otto livelli di omocodia della stessa base: nessuna sostituzione
            // e poi una cifra alla volta, da destra verso sinistra
            [
                "LRNCST94B08F104C"
            ],
            [
                "LRNCST94B08F10QZ"
            ],
            [
                "LRNCST94B08F1LQK"
            ],
            [
                "LRNCST94B08FMLQC"
            ],
            [
                "LRNCST94B0UFMLQZ"
            ],
            [
                "LRNCST94BLUFMLQK"
            ],
            [
                "LRNCST9QBLUFMLQW"
            ],
            [
                "LRNCSTVQBLUFMLQL"
            ],
            [
                "BDLMMD80B13Z33SK"
            ],
            [
                "RSSLRA80A41H501X"
            ],
            // Il 29 febbraio deve restare valido: l'anno è su due cifre, quindi
            // il secolo (e la bisestilità) non sono determinabili
            [
                "RSSMRA85B29A056W"
            ]
        ];
    }

    public function badDataProvider(): array
    {
        return [
            [
                ""
            ],
            [
                "!NTPTR60C29H5L1W"
            ],
            [
                "0NTPTR60C29H5L1S"
            ],
            [
                "MRARSS82M56F205IXXXX"
            ],
            [
                "MRARSS82M56F205I"
            ],
            [
                "LRNCST94B08F104Z"
            ],
            [
                "LRNCST94B08F104"
            ],
            [
                "1RNCST94B08F104Z"
            ],
            [
                "XRNCST94B08F104C"
            ],
            [
                "LXNCST94B08F10QZ"
            ],
            [
                "LRXCST94B08F1L4N"
            ],
            [
                "LRNXST94B08FM04U"
            ],
            [
                "LRNCXT94B0UF104Z"
            ],
            [
                "LRNCSXV4B08F104R"
            ],
            [
                "LRNCSTX4BL8F1LQV"
            ],
            [
                "LRNCSTVXB08F10QA"
            ],
            [
                "LRNCSTVQXLUFMLQL"
            ],
            [
                "RNCSTVQXLUFMLQL"
            ],
            // Checksum corretto ma mese inesistente: la lettera del mese deve essere
            // una delle dodici in uso, non un qualsiasi [A-Z]
            [
                "RSSMRA85F10A056O"
            ],
            [
                "RSSMRA85Z10A056Y"
            ],
            // Checksum corretto ma giorno di nascita fuori range
            [
                "RSSMRA85T00A056O"
            ],
            [
                "RSSMRA85T32A056V"
            ],
            // 40 non è né un giorno maschile (1-31) né femminile (41-71)
            [
                "RSSMRA85T40A056S"
            ],
            // Anche in forma omocodica (4L -> 40)
            [
                "RSSMRA85T4LA056V"
            ],
            // 99 diventerebbe il 59 giorno del mese
            [
                "RSSMRA85T99A056R"
            ],
            // Giorno non compatibile con il mese
            [
                "RSSMRA85D31A056J"
            ],
            [
                "RSSMRA85B30A056D"
            ],
            [
                "RSSMRA85D71A056N"
            ],
            // Input non alfanumerico della lunghezza giusta: non deve generare warning
            [
                "----------------"
            ],
            // Stringa UTF-8 da 8 caratteri ma 16 byte
            [
                "èèèèèèèè"
            ],
            // empty("0") è true: l'errore deve essere sulla lunghezza, non sull'assenza
            [
                "0"
            ],
            // Omocodia applicata in posizioni non contigue o non allineate a destra:
            // checksum corretto, ma forma non emettibile
            [
                "LRNCST94B08F1L4N"
            ],
            [
                "LRNCSTV4B08F104R"
            ],
            [
                "LRNCST94B08FM0QR"
            ],
            // Lettera del codice catastale mai assegnata: checksum corretto,
            // ma nessun comune né stato estero può avere quel codice
            [
                "RSSMRA85B01J056I"
            ],
            [
                "RSSMRA85B01W056V"
            ],
            // Terna di cognome/nome non producibile: le consonanti vengono
            // sempre prima delle vocali
            [
                "AABMRA85B01A056O"
            ],
            [
                "RSSABE85B01A056J"
            ]
        ];
    }

    /**
     * Nessun input, per quanto malformato, deve produrre warning/notice PHP
     *
     * @dataProvider badDataProvider
     */
    public function test_checker_does_not_emit_php_errors($badFiscalCode)
    {
        $errori = [];
        set_error_handler(function ($severity, $message) use (&$errori) {
            $errori[] = $message;
            return true;
        });

        try {
            $chk = new CodiceFiscale();
            $chk->validaCodiceFiscale($badFiscalCode);
        } finally {
            restore_error_handler();
        }

        self::assertSame([], $errori, "Errori PHP emessi per '$badFiscalCode'");
    }

    /**
     * Il messaggio di errore deve essere sempre uno di quelli previsti dalla classe,
     * mai un dettaglio interno del runtime
     *
     * @dataProvider badDataProvider
     */
    public function test_error_messages_are_from_the_known_list($badFiscalCode)
    {
        $chk = new CodiceFiscale();
        $chk->validaCodiceFiscale($badFiscalCode);

        self::assertContains($chk->getErrore(), [
            "Codice da analizzare assente",
            "Lunghezza codice da analizzare non corretta",
            "Il codice da analizzare contiene caratteri non corretti",
            "Alterazione per omocodia non valida",
            "Codice fiscale non corretto",
            "Data di nascita non valida"
        ], "Messaggio di errore inatteso per '$badFiscalCode'");
    }

    /**
     * L'alterazione per omocodia parte dalla cifra più a destra e prosegue verso
     * sinistra senza salti (DM 23/12/1976, art. 7). Tutti gli otto livelli della
     * stessa base sono validi e descrivono la stessa persona.
     *
     * @dataProvider omocodiaCanonicaDataProvider
     */
    public function test_omocodia_canonica_e_accettata($codiceFiscale, $livello)
    {
        $cf = new CodiceFiscale();

        self::assertTrue(
            $cf->validaCodiceFiscale($codiceFiscale),
            "Livello $livello ($codiceFiscale) rifiutato: " . $cf->getErrore()
        );

        // Tutti i livelli decodificano agli stessi dati anagrafici
        self::assertSame("08", $cf->getGiornoNascita(), "giorno, livello $livello");
        self::assertSame("02", $cf->getMeseNascita(), "mese, livello $livello");
        self::assertSame("94", $cf->getAnnoNascita(), "anno, livello $livello");
        self::assertSame("F104", $cf->getComuneNascita(), "comune, livello $livello");
        self::assertSame("M", $cf->getSesso(), "sesso, livello $livello");
    }

    public function omocodiaCanonicaDataProvider(): array
    {
        // Base LRNCST94B08F104C, sostituzioni progressive sulle posizioni
        // 15, 14, 13, 11, 10, 8, 7 (1-based), cioè da destra verso sinistra
        return [
            ["LRNCST94B08F104C", 0],
            ["LRNCST94B08F10QZ", 1],
            ["LRNCST94B08F1LQK", 2],
            ["LRNCST94B08FMLQC", 3],
            ["LRNCST94B0UFMLQZ", 4],
            ["LRNCST94BLUFMLQK", 5],
            ["LRNCST9QBLUFMLQW", 6],
            ["LRNCSTVQBLUFMLQL", 7]
        ];
    }

    /**
     * Un codice in cui una cifra è stata sostituita mentre una posizione più a
     * destra è rimasta numerica non è emettibile dall'Agenzia delle Entrate:
     * il carattere di controllo è corretto, ma la forma dell'omocodia non lo è.
     *
     * @dataProvider omocodiaNonCanonicaDataProvider
     */
    public function test_omocodia_non_canonica_e_rifiutata($codiceFiscale, $descrizione)
    {
        $cf = new CodiceFiscale();

        self::assertFalse(
            $cf->validaCodiceFiscale($codiceFiscale),
            "$codiceFiscale accettato ma $descrizione"
        );
        self::assertSame("Alterazione per omocodia non valida", $cf->getErrore(), $codiceFiscale);
        self::assertNull($cf->getGiornoNascita(), $codiceFiscale);
        self::assertNull($cf->getSesso(), $codiceFiscale);
    }

    public function omocodiaNonCanonicaDataProvider(): array
    {
        return [
            // Una sola posizione alterata, ma non quella più a destra
            ["LRNCST94B08F1L4N", "è alterata solo la 14ª cifra, la 15ª è ancora numerica"],
            ["LRNCST94B08FM04U", "è alterata solo la 13ª cifra"],
            ["LRNCST94B0UF104Z", "è alterata solo l'11ª cifra"],
            ["LRNCST94BL8F104N", "è alterata solo la 10ª cifra"],
            ["LRNCST9QB08F104O", "è alterata solo l'8ª cifra"],
            ["LRNCSTV4B08F104R", "è alterata solo la 7ª cifra"],
            // Sostituzioni non contigue: buco nella sequenza
            ["LRNCST94B08FM0QR", "la 15ª e la 13ª sono alterate ma la 14ª no"],
            ["LRNCST94BL8F1LQV", "la 10ª è alterata ma l'11ª e la 13ª no"],
            ["LRNCSTVQB08F10QA", "la 7ª e l'8ª sono alterate ma la 10ª, l'11ª e la 13ª no"]
        ];
    }

    /**
     * La lettera iniziale del codice catastale è limitata a quelle realmente
     * assegnate: A-M per i comuni italiani (l'alfabeto italiano non ha J e K)
     * e Z per gli stati esteri.
     *
     * @dataProvider comuneLetteraAmmessaDataProvider
     */
    public function test_lettera_comune_ammessa($codiceFiscale, $lettera)
    {
        $cf = new CodiceFiscale();

        self::assertTrue(
            $cf->validaCodiceFiscale($codiceFiscale),
            "Lettera $lettera rifiutata: " . $cf->getErrore()
        );
        self::assertSame($lettera . "056", $cf->getComuneNascita(), $codiceFiscale);
    }

    public function comuneLetteraAmmessaDataProvider(): array
    {
        return [
            ["RSSMRA85B01A056Z", "A"],
            ["RSSMRA85B01B056A", "B"],
            ["RSSMRA85B01C056B", "C"],
            ["RSSMRA85B01D056C", "D"],
            ["RSSMRA85B01E056D", "E"],
            ["RSSMRA85B01F056E", "F"],
            ["RSSMRA85B01G056F", "G"],
            ["RSSMRA85B01H056G", "H"],
            ["RSSMRA85B01I056H", "I"],
            ["RSSMRA85B01L056K", "L"],
            ["RSSMRA85B01M056L", "M"],
            // Stati esteri
            ["RSSMRA85B01Z056Y", "Z"]
        ];
    }

    /**
     * J e K non esistono nell'alfabeto italiano e non sono mai state usate nei
     * codici catastali; da N a Y non è mai stata assegnata alcuna lettera.
     * Il carattere di controllo è corretto, ma il comune non è rappresentabile.
     *
     * @dataProvider comuneLetteraNonAmmessaDataProvider
     */
    public function test_lettera_comune_non_ammessa($codiceFiscale, $lettera)
    {
        $cf = new CodiceFiscale();

        self::assertFalse(
            $cf->validaCodiceFiscale($codiceFiscale),
            "Lettera $lettera accettata come codice catastale"
        );
        self::assertSame(
            "Il codice da analizzare contiene caratteri non corretti",
            $cf->getErrore(),
            $codiceFiscale
        );
        self::assertNull($cf->getComuneNascita(), $codiceFiscale);
    }

    public function comuneLetteraNonAmmessaDataProvider(): array
    {
        return [
            ["RSSMRA85B01J056I", "J"],
            ["RSSMRA85B01K056J", "K"],
            ["RSSMRA85B01N056M", "N"],
            ["RSSMRA85B01O056N", "O"],
            ["RSSMRA85B01P056O", "P"],
            ["RSSMRA85B01Q056P", "Q"],
            ["RSSMRA85B01R056Q", "R"],
            ["RSSMRA85B01S056R", "S"],
            ["RSSMRA85B01T056S", "T"],
            ["RSSMRA85B01U056T", "U"],
            ["RSSMRA85B01V056U", "V"],
            ["RSSMRA85B01W056V", "W"],
            ["RSSMRA85B01X056W", "X"],
            ["RSSMRA85B01Y056X", "Y"]
        ];
    }

    /**
     * Le terne di cognome e nome si costruiscono prendendo le consonanti
     * nell'ordine, poi le vocali nell'ordine, riempiendo con X se le lettere
     * sono meno di tre. Tutte le forme risultanti devono essere accettate,
     * compreso il riempimento.
     *
     * @dataProvider ternaValidaDataProvider
     */
    public function test_terna_cognome_nome_valida($codiceFiscale, $descrizione)
    {
        $cf = new CodiceFiscale();

        self::assertTrue(
            $cf->validaCodiceFiscale($codiceFiscale),
            "$codiceFiscale rifiutato ($descrizione): " . $cf->getErrore()
        );
    }

    public function ternaValidaDataProvider(): array
    {
        return [
            ["RSSMRA85B01A056Z", "consonanti piene, poi consonanti e vocale"],
            ["DLCFNC85B01A056R", "sei consonanti"],
            ["AIXBCX85B01A056E", "vocali e riempimento, poi consonanti e riempimento"],
            ["EXXAXX85B01A056U", "una sola lettera per terna, doppio riempimento"],
            ["AEIOUX85B01A056S", "tre vocali, poi due vocali e riempimento"]
        ];
    }

    /**
     * Una vocale non può essere seguita da una consonante diversa dalla X di
     * riempimento: le consonanti vengono sempre prima. Il carattere di
     * controllo è corretto, ma la terna non è producibile dall'algoritmo.
     *
     * @dataProvider ternaNonValidaDataProvider
     */
    public function test_terna_cognome_nome_non_valida($codiceFiscale, $descrizione)
    {
        $cf = new CodiceFiscale();

        self::assertFalse(
            $cf->validaCodiceFiscale($codiceFiscale),
            "$codiceFiscale accettato ma $descrizione"
        );
        self::assertSame(
            "Il codice da analizzare contiene caratteri non corretti",
            $cf->getErrore(),
            $codiceFiscale
        );
    }

    public function ternaNonValidaDataProvider(): array
    {
        return [
            ["AABMRA85B01A056O", "nel cognome la B segue due vocali"],
            ["RSSABE85B01A056J", "nel nome la B è fra due vocali"],
            ["MRAAXB85B01A056D", "nel nome la B segue il riempimento"],
            ["ABXRSS85B01A056P", "nel cognome la B segue una vocale"],
            ["AXBCST85B01A056Y", "nel cognome la B segue la X"]
        ];
    }

    /**
     * @dataProvider parsingDataProvider
     */
    public function test_parsing_codice_fiscale($codiceFiscale, $expected)
    {
        $cf = new CodiceFiscale();

        $this->assertEquals($cf->validaCodiceFiscale($codiceFiscale), $expected['valid'], $codiceFiscale . " " . $cf->getErrore());

        $this->assertEquals($expected['sesso'], $cf->getSesso(), "Sesso errato per $codiceFiscale");
        $this->assertEquals($expected['comuneNascita'], $cf->getComuneNascita(), "Comune nascita errato per $codiceFiscale");
        $this->assertEquals($expected['annoNascita'], $cf->getAnnoNascita(), "Anno nascita errato per $codiceFiscale");
        $this->assertEquals($expected['meseNascita'], $cf->getMeseNascita(), "Mese nascita errato per $codiceFiscale");
        $this->assertEquals($expected['giornoNascita'], $cf->getGiornoNascita(), "Giorno nascita errato per $codiceFiscale");
    }

    public function parsingDataProvider()
    {
        return [
            [
                "MRARSS83B01F205Y",
                [
                    'sesso' => 'M',
                    'comuneNascita' => 'F205',
                    'annoNascita' => '83',
                    'meseNascita' => '02',
                    'giornoNascita' => '01',
                    'valid' => true
                ]
            ],
            [
                "MRARSS83B41F205C",
                [
                    'sesso' => 'F',
                    'comuneNascita' => 'F205',
                    'annoNascita' => '83',
                    'meseNascita' => '02',
                    'giornoNascita' => '01',
                    'valid' => true
                ]
            ],
            [
                "!RARSS83B41F205C",
                [
                    'sesso' => null,
                    'comuneNascita' => null,
                    'annoNascita' => null,
                    'meseNascita' => null,
                    'giornoNascita' => null,
                    'valid' => false
                ]
            ]
        ];
    }
}