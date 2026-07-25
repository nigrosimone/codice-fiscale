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
                "LMRBHM74A01Z3P0U"
            ],
            [
                "CNTPTR60C29H5L1W"
            ],
            [
                "MRARSS75P14H501I"
            ],
            [
                "MRARSS82M56F205J"
            ],
            [
                "LRNCST94B08F104C"
            ],
            [
                "LRNCST94B08F10QZ"
            ],
            [
                "LRNCST94B08F1L4N"
            ],
            [
                "LRNCST94B08FM04U"
            ],
            [
                "LRNCST94B0UF104Z"
            ],
            [
                "LRNCSTV4B08F104R"
            ],
            [
                "LRNCST94BL8F1LQV"
            ],
            [
                "LRNCSTVQB08F10QA"
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
            "Carattere non valido in decodifica omocodia",
            "Codice fiscale non corretto",
            "Data di nascita non valida"
        ], "Messaggio di errore inatteso per '$badFiscalCode'");
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