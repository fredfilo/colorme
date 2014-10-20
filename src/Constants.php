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
     * Base API url.
     */
    const API_URL = "https://api.shop-pro.jp";

    /**
     * Endpoint used for user authorization.
     */
    const AUTHORIZE_ENDPOINT = "/oauth/authorize";

    /**
     * Endpoint used to exchange an authorization code for an access token.
     */
    const ACCESS_TOKEN_ENDPOINT = "/oauth/token";

    /**
     * Endpoint for the Shop resource.
     */
    const SHOP_ENDPOINT = "/v1/shop";

    /**
     * Endpoint for the Category resources.
     */
    const CATEGORIES_ENDPOINT = "/v1/categories";

    /**
     * Endpoint for the Product resources.
     */
    const PRODUCTS_ENDPOINT = "/v1/products";

    /**
     * Endpoint for the Sale resources.
     */
    const SALES_ENDPOINT = "/v1/sales";

    /**
     * Endpoint for the SaleStat resources.
     */
    const SALES_STAT_ENDPOINT = "/v1/sales/stat";

    /**
     * Endpoint for the Payment resources.
     */
    const PAYMENTS_ENDPOINT = "/v1/payments";

    /**
     * Endpoint for the Customer resources.
     */
    const CUSTOMERS_ENDPOINT = "/v1/customers";

    /**
     * Endpoint for the Gifts resources.
     */
    const GIFTS_ENDPOINT = "/v1/gifts";

    /**
     * Endpoint for the Stocks resources.
     */
    const STOCKS_ENDPOINT = "/v1/stocks";

    /**
     * Endpoint for the Delivery resources.
     */
    const DELIVERIES_ENDPOINT = "/v1/deliveries/date";

    /**
     * Endpoint for the DeliveryDate resources.
     */
    const DELIVERIES_DATE_ENDPOINT = "/v1/deliveries/date";

// STATIC PROPERTIES ===========================================================
// STATIC FUNCTIONS ============================================================
// PROPERTIES ==================================================================
// GETTERS =====================================================================
// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC METHODS ==============================================================
// PROTECTED METHODS ===========================================================
// PRIVATE METHODS =============================================================
}
