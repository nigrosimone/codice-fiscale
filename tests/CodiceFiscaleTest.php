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
            ]
        ];
    }
}
