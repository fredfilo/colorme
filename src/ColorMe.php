<?php

namespace ColorMe;

use ColorMe\Auth;
use ColorMe\Resource\Shop;
use ColorMe\Resource\Category;
use ColorMe\Resource\Product;
use ColorMe\Resource\Customer;
use ColorMe\Resource\Sale;
use ColorMe\Resource\SaleStat;
use ColorMe\Resource\Stock;
use ColorMe\Resource\Payment;
use ColorMe\Resource\Delivery;
use ColorMe\Resource\DeliveryDate;
use ColorMe\Resource\Gift;

/**
 * ColorMe - Api client for the Japanese e-commerce platform
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ColorMe
{
// CONSTANTS ===================================================================
// STATIC PROPERTIES ===========================================================
// STATIC FUNCTIONS ============================================================
// PROPERTIES ==================================================================

    /**
     * @var \ColorMe\Auth
     */
    protected $auth;

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

    public function setAuth(\ColorMe\Auth $auth)
    {
        $this->auth = $auth;
    }

// CONSTRUCTOR =================================================================

    public function __construct()
    {
        $this->auth = new Auth();
    }

// PUBLIC METHODS ==============================================================

    public function shop($id = null)
    {
        return new Shop($this->auth, $id);
    }

    public function categories($id = null)
    {
        return new Category($this->auth, $id);
    }

    public function products($id = null)
    {
        return new Product($this->auth, $id);
    }

    public function customers($id = null)
    {
        return new Customer($this->auth, $id);
    }

    public function sales($id = null)
    {
        return new Sale($this->auth, $id);
    }

    public function salesStat($id = null)
    {
        return new SaleStat($this->auth, $id);
    }

    public function payments($id = null)
    {
        return new Payment($this->auth, $id);
    }

    public function deliveries($id = null)
    {
        return new Delivery($this->auth, $id);
    }

    public function deliveriesDate($id = null)
    {
        return new DeliveryDate($this->auth, $id);
    }

    public function stocks($id = null)
    {
        return new Stock($this->auth, $id);
    }

    public function gifts($id = null)
    {
        return new Gift($this->auth, $id);
    }

// PROTECTED METHODS ===========================================================
// PRIVATE METHODS =============================================================
}
