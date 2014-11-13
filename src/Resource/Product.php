<?php

namespace ColorMe\Resource;

use ColorMe\Constants;

/**
 * Product
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Product extends Resource
{
// CONSTANTS ===================================================================
// STATIC ======================================================================
// PROPERTIES ==================================================================

    /**
     * @var array Array of allowed methods. Subclasses must set this.
     */
    protected $allowedMethods = array("GET", "PUT");

    /**
     * @var string The response key containing the single item information.
     */
    protected $itemKey = "product";

    /**
     * @var string The response key containing the items information.
     */
    protected $itemsKey = "products";

    /**
     * @var string The endpoint used to access the resource from the base url.
     */
    protected $endpoint = Constants::PRODUCTS_ENDPOINT;

// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================

    /**
     * @param $properties array Optional array of body content.
     * @return array
     */
    public function put(array $properties = null)
    {
        if (!is_null($properties)) {
            $properties = array("product" => $properties);
        }

        return parent::put($properties);
    }

// PROTECTED ===================================================================
// PRIVATE =====================================================================
}
