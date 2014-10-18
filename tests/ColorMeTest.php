<?php

use ColorMe\ColorMe;

/**
 * ColorMeTest
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ColorMeTest extends PHPUnit_Framework_TestCase
{
// CONSTANTS ===================================================================

    const DUMMY_CLIENT_ID = "rtuadhbk3dgl6vsjfgoi8rhf0lsdg2oirgfolsdf";
    const DUMMY_CLIENT_SECRET = "tyydsfjhrwe34t546o57676iabmihsgortehhdsf";
    const DUMMY_REDIRECT_URI = "http://dummy.example.com/test/colorme/auth";
    const DUMMY_ACCESS_TOKEN = "abcdefghijklmnopqrstuvwxyz0123456789";

// STATIC ======================================================================
// PROPERTIES ==================================================================
// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================

    public function testAuthProperty()
    {
        $colorme = $this->getInstanceInitialized();
        $this->assertTrue(is_a($colorme->auth, "\ColorMe\Auth"));
    }

// PROTECTED ===================================================================
// PRIVATE =====================================================================

    private function getInstanceInitialized()
    {
        $colorme = new ColorMe();
        $colorme->auth->clientId = self::DUMMY_CLIENT_ID;
        $colorme->auth->clientSecret = self::DUMMY_CLIENT_SECRET;
        $colorme->auth->redirectUri = self::DUMMY_REDIRECT_URI;
        $colorme->auth->accessToken = self::DUMMY_ACCESS_TOKEN;
        return $colorme;
    }
}