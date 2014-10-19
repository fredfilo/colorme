<?php

namespace ColorMe\Resource;

use ColorMe\Constants;

/**
 * Category
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Category extends Resource
{
// CONSTANTS ===================================================================
// STATIC ======================================================================
// PROPERTIES ==================================================================

    /**
     * @var array Array of allowed methods. Subclasses must set this.
     */
    protected $allowedMethods = array("GET");

    /**
     * @var string The response key containing the single item information.
     */
    protected $itemKey = null;

    /**
     * @var string The response key containing the items information.
     */
    protected $itemsKey = "categories";

    /**
     * @var string The endpoint used to access the resource from the base url.
     */
    protected $endpoint = Constants::CATEGORIES_ENDPOINT;

// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================
// PROTECTED ===================================================================

    /**
     * Creates a response object by paring the API response.
     *
     * @param $method string The Http method.
     * @param $rawResponse mixed The Http response.
     * @return \ColorMe\Response\Response
     */
    protected function makeResponse($method, $rawResponse)
    {
        $response = parent::makeResponse($method, $rawResponse);

        // The Category endpoint doesn't match the behavior of other responses:
        // Even if a list of categories is returned, there is no way to have
        // a pagination because the `meta` property is not present.
        // Providing `offset` and `limit` in the request doesn't work either.
        if (is_array($response->items)) {
            $response->total = count($response->items);
            $response->offset = 0;
            $response->limit = $response->total;
        }

        return $response;
    }

// PRIVATE =====================================================================
}
