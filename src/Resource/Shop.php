<?php

namespace ColorMe\Resource;

use ColorMe\Constants;
use ColorMe\Resource\Resource;
use ColorMe\Exception\RequestException;

/**
 * Shop
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Shop extends Resource
{
// CONSTANTS ===================================================================
// STATIC ======================================================================
// PROPERTIES ==================================================================
// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================

    /**
     * Returns the raw URL that may contain placeholders.
     *
     * @return string The raw URL.
     */
    public function getRawUrl($method)
    {
        $url = null;
        if ($method == "GET") {
            $url = Constants::URL_SHOP;
        }
        return $url;
    }

// PROTECTED ===================================================================

    /**
     * Parses the API response.
     *
     * @return mixed
     */
    protected function parseResponse($method, $response)
    {
        if (is_array($response) && array_key_exists("shop", $response)) {
            return $response["shop"];
        } else {
            $message = "Invalid Shop response. The API may have changed.";
            throw new RequestException($message);
        }
    }

// PRIVATE =====================================================================
}