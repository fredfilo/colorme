<?php

namespace ColorMe;

use ColorMe\Constants;
use ColorMe\Exception\AuthorizationException;
use GuzzleHttp\Client as HttpClient;

/**
 * Auth
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Auth
{
// CONSTANTS ===================================================================
// STATIC ======================================================================
// PROPERTIES ==================================================================

    /**
     * @var string The client ID of your application.
     * @link http://api.shop-pro.jp/oauth/applications
     */
    public $clientId;

    /**
     * @var string The client secret of your application.
     * @link http://api.shop-pro.jp/oauth/applications
     */
    public $clientSecret;

    /**
     * @var string The URL where ColorMe will redirect the user after
     *             authorization.
     * @link http://api.shop-pro.jp/oauth/applications
     */
    public $redirectUri;

    /**
     * @var string The access token used to make API requests.
     */
    public $accessToken;

    /**
     * @var string The code received after user's authorization.
     */
    public $authorizationCode;

// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================

    /**
     * Returns the URL where the user should be sent for authorization.
     *
     * @param  array  $scope The permissions required by the application.
     *                       Include one or many of the following:
     *                       - read_products
     *                       - write_products
     *                       - read_sales
     *                       - write_sales
     * @return string
     */
    public function getAuthorizationUrl(array $scope)
    {
        $joinedScope = implode(" ", $scope);

        $parameters = array(
            "client_id=" . urlencode($this->clientId),
            "response_type=code",
            "scope=" . urlencode($joinedScope),
            "redirect_uri=" . urlencode($this->redirectUri),
        );

        return Constants::API_URL
               . Constants::AUTHORIZE_ENDPOINT
               . "?" . implode("&", $parameters);
    }

    /**
     * Requests an access token using the received authorization code.
     *
     * @param  string $code Optional authorization code. If it is not provided,
     *                      we'll look for it into $_GET.
     * @return string
     * @throws \RuntimeException If the authorization code can't be found.
     */
    public function requestAccessToken($code = null)
    {
        if (is_null($code) && array_key_exists("code", $_GET)) {
            $this->authorizationCode = $_GET["code"];
        } else {
            $this->authorizationCode = $code;
        }

        if (!is_string($this->authorizationCode)) {

            if (array_key_exists("error_description", $_GET)) {
                $error = $_GET['error_description'];
            } elseif (array_key_exists("error", $_GET)) {
                $error = $_GET['error'];
            } else {
                $error = "The authorization code is not provided "
                       . "and cannot be retreived in \$_GET";
            }

            throw new AuthorizationException($error);
        }

        $this->accessToken = null;

        $http = new HttpClient();
        $url = Constants::API_URL . Constants::ACCESS_TOKEN_ENDPOINT;
        $request = $http->createRequest("POST", $url);
        $body = $request->getBody();
        $body->setField("client_id", $this->clientId);
        $body->setField("client_secret", $this->clientSecret);
        $body->setField("code", $this->authorizationCode);
        $body->setField("grant_type", "authorization_code");
        $body->setField("redirect_uri", $this->redirectUri);

        try {
            $response = $http->send($request)->json();
            $this->accessToken = $response["access_token"];
        } catch (\Exception $e) {
            $error = "An error occurred while parsing access token response.";
            throw new AuthorizationException($error);
        }

        return $this->accessToken;
    }

    /**
     * Returns the `Authorization` header used to authorize API requests.
     *
     * @return string
     */
    public function getAuthorizationHeader()
    {
        if (is_string($this->accessToken)) {
            return "Bearer {$this->accessToken}";
        } else {
            return null;
        }
    }

// PROTECTED ===================================================================
// PRIVATE =====================================================================
}