<?php

use ColorMe\Auth;

/**
 * AuthTest
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AuthTest extends PHPUnit_Framework_TestCase
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

    public function testAuthorizationUrl()
    {
        $scope = array(
            'read_products',
        );

        $expectedUrl = "https://api.shop-pro.jp/oauth/authorize?"
                     . "client_id=" . self::DUMMY_CLIENT_ID
                     . "&response_type=code"
                     . "&scope=" . urlencode(implode(" ", $scope))
                     . "&redirect_uri=" . urlencode(self::DUMMY_REDIRECT_URI);

        $auth = $this->getAuthInitialized();
        $receivedUrl = $auth->getAuthorizationUrl($scope);

        $this->assertEquals($expectedUrl, $receivedUrl);
    }

    public function testAuthenticationHeader()
    {
        $auth = $this->getAuthInitialized();

        $expectedHeader = "Bearer " . self::DUMMY_ACCESS_TOKEN;
        $receivedHeader = $auth->getAuthorizationHeader();

        $this->assertEquals($expectedHeader, $receivedHeader);
    }

    /**
     * @expectedException \ColorMe\Exception\AuthorizationException
     */
    public function testRequestTokenWithNoAuthorizationCode()
    {
        $auth = $this->getAuthInitialized();
        $accessToken = $auth->requestAccessToken();
    }

// PROTECTED ===================================================================
// PRIVATE =====================================================================

    private function getAuthInitialized()
    {
        $auth = new Auth();
        $auth->clientId = self::DUMMY_CLIENT_ID;
        $auth->clientSecret = self::DUMMY_CLIENT_SECRET;
        $auth->redirectUri = self::DUMMY_REDIRECT_URI;
        $auth->accessToken = self::DUMMY_ACCESS_TOKEN;
        return $auth;
    }
}