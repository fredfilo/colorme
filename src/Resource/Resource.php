<?php

namespace ColorMe\Resource;

use ColorMe\Auth;
use ColorMe\Constants;
use ColorMe\Response\Response;
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
// STATIC ======================================================================
// PROPERTIES ==================================================================

    /**
     * @var int|string The resource id.
     */
    public $id;

    /**
     * @var \ColorMe\Auth
     */
    protected $auth;

    /**
     * @var array Array of allowed methods. Subclasses must set this.
     */
    protected $allowedMethods = array();

    /**
     * @var string The response key containing the single item information.
     */
    protected $itemKey;

    /**
     * @var string The response key containing the items information.
     */
    protected $itemsKey;

    /**
     * @var string The endpoint used to access the resource from the base url.
     */
    protected $endpoint;

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

    /**
     * @param $id int|string
     * @return \ColorMe\Resource\Resource
     * @throws \InvalidArgumentException If $id doesn't represent an integer.
     */
    public function setId($id)
    {
        if (!is_null($id) && !is_int($id) && (!is_string($id) || !ctype_digit($id))) {
            $message = "The resource id must represent an integer.";
            throw new \InvalidArgumentException($message);
        }

        $this->id = $id;
        return $this;
    }

// CONSTRUCTOR =================================================================

    public function __construct(\ColorMe\Auth $auth, $id = null)
    {
        $this->setAuth($auth)
             ->setId($id);
    }

// PUBLIC ======================================================================

    /**
     * Returns true if the provided Http method is allowed.
     *
     * @return boolean
     */
    public function isAllowedMethod($method)
    {
        $allowed = false;
        if (is_string($method)) {
            return in_array(strtoupper($method), $this->allowedMethods);
        }
        return $allowed;
    }

    public function isSingleAllowed()
    {
        return is_string($this->itemKey);
    }

    public function isCollectionAllowed()
    {
        return is_string($this->itemsKey);
    }

    public function hasId()
    {
        return !is_null($this->id);
    }

    /**
     * Returns the URL corresponding to the Http method.
     *
     * @return string The raw URL.
     */
    public function getUrl()
    {
        $url = Constants::API_URL . $this->endpoint;
        if ($this->hasId()) {
            $url .= "/" . $this->id;
        }
        $url .= ".json";
        return $url;
    }

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

// PROTECTED ===================================================================

    protected function execute($method, array $filters = null, array $properties = null)
    {
        $url = $this->getUrl();

        $makeRequestException = function($msg) use ($url, $method, $filters, $properties)
        {
            $e = new RequestException($msg);
            $e->url = $url;
            $e->method = $method;
            $e->filters = $filters;
            $e->properties = $properties;
            return $e;
        };

        if (!$this->isAllowedMethod($method)) {
            $message = "The Http method {$method} is not allowed.";
            throw $makeRequestException($message);
        }

        if ($this->hasId()) {
            if (!$this->isSingleAllowed()) {
                $message = "A request by id is not allowed.";
                throw $makeRequestException($message);
            }
        } elseif (!$this->isCollectionAllowed()) {
            $message = "A request of many items is not allowed.";
            throw $makeRequestException($message);
        }

        $http = new HttpClient();
        $request = $http->createRequest($method, $url);

        if (is_array($filters)) {
            $query = $request->getQuery();
            foreach ($filters as $key => $value) {
                $query->set($key, $value);
            }
        }

        if (is_array($properties)) {

            switch ($method) {

                case 'POST':
                    $body = $request->getBody();
                    foreach ($properties as $key => $value) {
                        $body->setField($key, $value);
                    }
                    break;

                case 'PUT':
                    $stream = json_encode($properties);
                    $body = \GuzzleHttp\Stream\Stream::factory($stream);
                    $request->setBody($body);
                    $request->setHeader("Content-Type", "application/json");
                    break;

                default:
                    break;
            }

        }

        $authHeader = $this->auth->getAuthorizationHeader();
        $request->setHeader("Authorization", $authHeader);

        $httpResponse = null;

        try {

            $startTime = microtime(true);
            $httpResponse = $http->send($request);
            $duration = (microtime(true) - $startTime);

            $httpResponse = $httpResponse->json();
            $response = $this->makeResponse($method, $httpResponse);
            $response->duration = $duration;
            return $response;

        } catch (\Exception $e) {

            $message = "An exception occurred while parsing response."
                     . " | Exception: " . $e->getMessage();

            $e = $makeRequestException($message);
            $e->response = $httpResponse;
            throw $e;

        }
    }

    /**
     * Creates a response object by paring the API response.
     *
     * @param $method string The Http method.
     * @param $rawResponse mixed The Http response.
     * @return \ColorMe\Response\Response
     */
    protected function makeResponse($method, $rawResponse)
    {
        $error = false;
        $response = new Response();
        $response->itemKey = $this->itemKey;
        $response->itemsKey = $this->itemsKey;

        if ($this->hasId()) {

            if (!array_key_exists($this->itemKey, $rawResponse)) {
                $error = true;
            }

            $response->id = $this->id;
            $response->item = $rawResponse[$this->itemKey];

        } else {

            if (!array_key_exists($this->itemsKey, $rawResponse)) {
                $error = true;
            }

            $response->items = $rawResponse[$this->itemsKey];

            if (array_key_exists("meta", $rawResponse)) {
                $response->total = $rawResponse["meta"]["total"];
                $response->offset = $rawResponse["meta"]["offset"];
                $response->limit = $rawResponse["meta"]["limit"];
            }

        }

        if ($error === true) {
            $message = "Invalid " . get_called_class() . " response. "
                     . "The API may have changed.";
            throw new RequestException($message);
        }

        return $response;
    }

// PRIVATE =====================================================================
}
