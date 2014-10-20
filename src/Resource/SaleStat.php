<?php

namespace ColorMe\Resource;

use ColorMe\Constants;

/**
 * SaleStat
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class SaleStat extends Resource
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
    protected $itemsKey = "sales_stat";

    /**
     * @var string The endpoint used to access the resource from the base url.
     */
    protected $endpoint = Constants::SALES_STAT_ENDPOINT;

// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================
// PROTECTED ===================================================================
// PRIVATE =====================================================================
}
