<?php

namespace ColorMe\Resource;

use ColorMe\Auth;
use ColorMe\Exception\RequestException;
use GuzzleHttp\Client as HttpClient;

/**
 * Resource
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
abstract class Resource
{
// CONSTANTS ===================================================================
// ABSTRACT ====================================================================

    /**
     * Returns the raw URL that may contain placeholders.
     *
     * @return string The raw URL.
     */
    public abstract function getRawUrl($method);

    /**
     * Parses the API response.
     *
     * @return mixed
     */
    protected abstract function parseResponse($method, $response);

// STATIC ======================================================================
// PROPERTIES ==================================================================

    /**
     * @var \ColorMe\Auth
     */
    protected $auth;

    /**
     * @var int|string The resource id.
     */
    public $id;

// GETTERS =====================================================================

    public function __get($key)
    {
        if ($key == "auth") {
            return $this->auth;
        } else {
            throw new \Exception("The property {$key} doesn't exist.");
        }
    }

// SETTERS =====================================================================

    /**
     * @param $auth \ColorMe\Auth
     * @return \ColorMe\Resource\Resource
     */
    public function setAuth(\ColorMe\Auth $auth)
    {
        $this->auth = $auth;
        return $this;
    }

// CONSTRUCTOR =================================================================

    public function __construct(\ColorMe\Auth $auth, $id = null)
    {
        $this->setAuth($auth);
        $this->id = $id;
    }

// PUBLIC ======================================================================

    /**
     * @param $filters array Optional array of query string parameters.
     * @return array
     */
    public function get(array $filters = null)
    {
        return $this->execute("GET", $filters);
    }

    /**
     * @param $properties array Optional array of body content.
     * @return array
     */
    public function post(array $properties = null)
    {
        return $this->execute("POST", null, $properties);
    }

    /**
     * @param $properties array Optional array of body content.
     * @return array
     */
    public function put(array $properties = null)
    {
        return $this->execute("PUT", null, $properties);
    }

    /**
     * @param $filters array Optional array of query string parameters.
     * @return array
     */
    public function delete(array $filters = null)
    {
        return $this->execute("DELETE", $filters);
    }

    /**
     * Returns the final URL filled with the resource id if necessary.
     *
     * @return string The final URL.
     */
    public function getUrl($method)
    {
        $url = $this->getRawUrl($method);

        if (!is_string($url)) {

            $message = "The Http method {$method} is not allowed.";
            $e = new RequestException($message);
            $e->method = $method;
            $e->url = $url;
            $e->filters = $filters;
            $e->properties = $properties;
            throw $e;

        }

        if (is_int($this->id) || (is_string($this->id) && ctype_digit($this->id))) {
            $url = sprintf($url, $this->id);
        }

        return $url;
    }

// PROTECTED ===================================================================

    protected function execute(
        $method,
        array $filters = null,
        array $properties = null
    ) {
        $http = new HttpClient();
        $url = $this->getUrl($method);
        $request = $http->createRequest($method, $url);

        if (is_array($filters)) {
            $query = $request->getQuery();
            foreach ($filters as $key => $value) {
                $query->set($key, $value);
            }
        }

        if (is_array($properties)) {
            $body = $request->getBody();
            foreach ($properties as $key => $value) {
                $body->setField($key, $value);
            }
        }

        $authHeader = $this->auth->getAuthorizationHeader();
        $request->setHeader("Authorization", $authHeader);

        $response = null;

        try {

            $response = $http->send($request);
            $response = $response->json();
            return $this->parseResponse($method, $response);

        } catch (\Exception $e) {

            $message = "An error occurred while parsing response: "
                     . $e->getMessage();

            $e = new RequestException($message);
            $e->method = $method;
            $e->url = $url;
            $e->filters = $filters;
            $e->properties = $properties;
            $e->response = $response;

            throw $e;

        }
    }

// PRIVATE =====================================================================
}
