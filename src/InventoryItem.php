<?php

namespace App;

class InventoryItem extends Item
{
    public const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    public const BACKSTAGE_PASS = 'Backstage passes to a TAFKAL80ETC concert';
    public const BRIE = 'Aged Brie';

    /**
     * @var bool Whether or not the item has been conjured
     */
    public $conjured;

    public function __construct($name, $quality, $sellIn, $conjured = false)
    {
        parent::__construct($name, $quality, $sellIn);

        $this->conjured = $conjured;
    }

    /**
     * Reduce the sell in date by one, ignoring exempt items
     *
     * @return void
     */
    public function updateSellIn()
    {
        if ($this->name !== self::SULFURAS) {
            $this->sellIn--;
        }
    }

    /**
     * Update the quality of inventory items
     *
     * @return void
     */
    public function updateQuality()
    {
        $degradeAmount = 0; // Total amount to reduce the quality by after mutators

        if ($this->doesDegrade() && $this->quality > 0) {
            if ($this->quality !== 0) {
                $degradeAmount++;
            }

            if ($this->sellIn <= 0) {
                $degradeAmount++;
            }

            if ($this->conjured) {
                $degradeAmount *= 2;
            }

            $this->quality -= $degradeAmount;

            if ($this->quality < 0) {
                $this->quality = 0;
            }
        } else {
            if ($this->name === self::BACKSTAGE_PASS) {
                $this->updateBackstagePass();
            }
            if ($this->name === self::BRIE) {
                $this->updateBrie();
            }
        }
    }

    /**
     * Checks if the current item is an exempt item or not
     *
     * @return bool Returns false on an exempt item, otherwise true.
     */
    public function doesDegrade(): bool
    {
        return ($this->name !== self::SULFURAS &&
            $this->name !== self::BACKSTAGE_PASS &&
            $this->name !== self::BRIE);
    }

    /**
     * If the current item is Aged Brie, update the quality details
     *
     * @return void
     */
    private function updateBrie()
    {
        if ($this->quality < 50) {
            $this->quality++;
            if ($this->sellIn <= 0 && $this->quality < 50) {
                $this->quality++;
            }
        }
    }

    /**
     * If the current item is the Backstage Pass, update the quality details depending on sell date
     *
     * @return void
     */
    private function updateBackstagePass()
    {
        $this->quality++;
        if ($this->sellIn <= 0) {
            $this->quality = 0;
        } elseif ($this->sellIn <= 5) {
            $this->quality += 2;
        } elseif ($this->sellIn <= 10) {
            $this->quality += 1;
        }

        if ($this->quality > 50) {
            $this->quality = 50;
        }
    }
}
