<?php

namespace ColorMe\Response;

/**
 * Response
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright 2014 - applistic.
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Response
{
// CONSTANTS ===================================================================
// STATIC ======================================================================
// PROPERTIES ==================================================================

    /**
     * @var int|string The single item's id.
     */
    public $id;

    /**
     * @var array The single item identified by the `id` property.
     */
    public $item;

    /**
     * @var array The list of items.
     */
    public $items;

    /**
     * @var int The total number of items available (ignores offset and limit).
     */
    public $total;

    /**
     * @var int The offset from where the items were requested.
     */
    public $offset;

    /**
     * @var int The number of items requested.
     */
    public $limit;

    /**
     * @var string The single resource identifier.
     *             This key can be used as an alias for `item`.
     */
    public $itemKey;

    /**
     * @var string The resources identifier.
     *             This key can be used as an alias for `items`.
     */
    public $itemsKey;

    /**
     * @var int The API call duration in seconds.
     */
    public $duration;

// GETTERS =====================================================================

    public function __get($key)
    {
        switch ($key) {
            case $this->itemKey:
                return $this->item;
            case $this->itemsKey:
                return $this->items;
            default:
                $message = "The property {$key} doesn't exist.";
                throw new \RuntimeException($message);
        }
    }

// SETTERS =====================================================================
// CONSTRUCTOR =================================================================
// PUBLIC ======================================================================

    /**
     * Returns true if more items exist after the current list.
     *
     * @return boolean
     */
    public function hasMore()
    {
        return ($this->total > ($this->offset + $this->limit));
    }

    /**
     * Returns true if the first item available is in the list.
     *
     * @return boolean
     */
    public function hasFirst()
    {
        return (!is_null($this->id) || ($this->offset == 0));
    }

// PROTECTED ===================================================================
// PRIVATE =====================================================================
}