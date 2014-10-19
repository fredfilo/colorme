<?php

namespace ColorMe\Resource;

use ColorMe\Constants;
use ColorMe\Exception\RequestException;

/**
 * Sale
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Sale extends Resource
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
    protected $itemKey = "sale";

    /**
     * @var string The response key containing the items information.
     */
    protected $itemsKey = "sales";

    /**
     * @var string The endpoint used to access the resource from the base url.
     */
    protected $endpoint = Constants::SALES_ENDPOINT;

    /**
     * @var boolean Flag indicating that the request is for a Cancel operation.
     */
    protected $cancel = false;

// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================

    public function cancel(array $properties = null)
    {
        if (!$this->hasId()) {
            $message = "The `cancel` operation requires a resource id.";
            throw new RequestException($message);
        }

        $this->execute("PUT", null, $properties);
    }

    /**
     * Returns the URL corresponding to the Http method.
     *
     * @return string The raw URL.
     */
    public function getUrl()
    {
        $url = parent::getUrl();
        if ($this->cancel === true) {
            $url = str_replace(".json", "/cancel.json", $url);
        }
        return $url;
    }

// PROTECTED ===================================================================
// PRIVATE =====================================================================
}
