<?php

namespace ColorMe;

use ColorMe\Auth;

/**
 * ColorMe - Api client for the Japanese e-commerce platform
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ColorMe
{
// ===== CONSTANTS =============================================================
// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================

    /**
     * @var \ColorMe\Auth
     */
    public $auth;

// ===== ACCESSORS =============================================================
// ===== CONSTRUCTOR ===========================================================

    public function __construct()
    {
        $this->auth = new Auth();
    }

// ===== PUBLIC METHODS ========================================================
// ===== PROTECTED METHODS =====================================================
// ===== PRIVATE METHODS =======================================================
}