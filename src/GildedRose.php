<?php

namespace App;

class GildedRose
{
    /**
     * @var Array An array of inventory items
     */
    private $items;

    /**
     * Create a new instance of the Gilded Rose class
     *
     * @param Array $items The inventory items to check
     *
     * @return void
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Return a specific item from the $items array
     *
     * @param String|null $which - The name of the itemor nul to return the full array
     *
     * @return Item|Array - The request item object or the full item array
     */
    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]);
    }

    /**
     * Tick over the day and update the sellIn and Quality properties for all inventory items
     *
     * @return void
     */
    public function nextDay()
    {
        foreach ($this->items as $item) {
            $item->handle();
        }
    }
}
