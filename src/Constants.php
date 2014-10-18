<?php

namespace ColorMe;

/**
 * Constants
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * @see  http://shop-pro.jp/?mode=api_started For authorization URLs
 * @see  http://shop-pro.jp/?mode=api_interface For endpoint URLs
 */
class Constants
{
// CONSTANTS ===================================================================

    // URLs --------------------------------------------------------------------

    /**
     * Endpoint used for user authorization.
     */
    const URL_AUTHORIZE = "https://api.shop-pro.jp/oauth/authorize";

    /**
     * Endpoint used to exchange an authorization code for an access token.
     */
    const URL_ACCESS_TOKEN = "https://api.shop-pro.jp/oauth/token";

    /**
     * Endpoint for the Shop resource.
     */
    const URL_SHOP = "https://api.shop-pro.jp/v1/shop.json";

    /**
     * Endpoint for the Category resources.
     */
    const URL_CATEGORIES = "https://api.shop-pro.jp/v1/categories.json";

    /**
     * Endpoint for the Product resources.
     */
    const URL_PRODUCTS = "https://api.shop-pro.jp/v1/products.json";

    /**
     * Endpoint for a single Product resource.
     */
    const URL_PRODUCT_SINGLE = "https://api.shop-pro.jp/v1/products/%d.json";

    /**
     * Endpoint for the Sale resources.
     */
    const URL_SALES = "https://api.shop-pro.jp/v1/sales.json";

    /**
     * Endpoint for a single Sale resource.
     */
    const URL_SALE_SINGLE = "https://api.shop-pro.jp/v1/sales/%d.json";

    /**
     * Endpoint for the Payment resources.
     */
    const URL_PAYMENTS = "https://api.shop-pro.jp/v1/payments.json";

    /**
     * Endpoint for the Customer resources.
     */
    const URL_CUSTOMERS = "https://api.shop-pro.jp/v1/customers.json";

    /**
     * Endpoint for a single Customer resource.
     */
    const URL_CUSTOMER_SINGLE = "https://api.shop-pro.jp/v1/customers/%d.json";

// STATIC PROPERTIES ===========================================================
// STATIC FUNCTIONS ============================================================
// PROPERTIES ==================================================================
// ACCESSORS ===================================================================
// CONSTRUCTOR =================================================================
// PUBLIC METHODS ==============================================================
// PROTECTED METHODS ===========================================================
// PRIVATE METHODS =============================================================
}