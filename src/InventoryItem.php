<?php

namespace App;

use App\Interfaces\ItemInterface;

class InventoryItem extends Item implements ItemInterface
{
    public const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    public const BACKSTAGE_PASS = 'Backstage passes to a TAFKAL80ETC concert';
    public const BRIE = 'Aged Brie';

    /**
     * @var int The lowest possible quality
     */
    public const MIN_QUALITY = 0;

    /**
     * @var int The highest possible quality for non-legendary items
     */
    public const MAX_QUALITY = 50;

    /**
     * @var bool Whether or not the item has been conjured
     */
    public $conjured;

    /**
     * Create a new instance of the InventoryItem class
     *
     * @param string $name - Name of the item
     * @param int $quality - The current quality
     * @param int $sellIn - Number of days until the sell by date
     * @param bool $conjured - whether the item is conjured or not
     *
     * @return void
     */
    public function __construct(string $name, int $quality, int $sellIn, bool $conjured = false)
    {
        parent::__construct($name, $quality, $sellIn);

        $this->conjured = $conjured;
    }

    /**
     * Reduce the sell in date by one, ignoring exempt items
     *
     * @return void
     */
    public function decreaseSellIn()
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
    public function handle()
    {

        if ($this->doesDegrade() && $this->quality > self::MIN_QUALITY) {
            $this->updateNormal();
        } else {
            $this->updateBackstagePass();
            $this->updateBrie();
        }
        $this->decreaseSellIn();
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
     * If the current item is a non-exempt item, update the quality details
     *
     * @return void
     */
    private function updateNormal()
    {
        $degradeAmount = 1; // Total amount to reduce the quality by after mutators
        if ($this->sellIn <= 0) {
            $degradeAmount++;
        }

        if ($this->conjured) {
            $degradeAmount *= 2;
        }

        $this->quality -= $degradeAmount;

        if ($this->quality < self::MIN_QUALITY) {
            $this->quality = self::MIN_QUALITY;
        }
    }

    /**
     * If the current item is Aged Brie, update the quality details
     *
     * @return void
     */
    private function updateBrie()
    {
        if ($this->name !== self::BRIE) {
            return;
        }
        if ($this->quality < self::MAX_QUALITY) {
            $this->quality++;
            if ($this->sellIn <= 0 && $this->quality < self::MAX_QUALITY) {
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
        if ($this->name !== self::BACKSTAGE_PASS) {
            return;
        }

        $this->quality++;
        if ($this->sellIn <= 0) {
            $this->quality = self::MIN_QUALITY;
        } elseif ($this->sellIn <= 5) {
            $this->quality += 2;
        } elseif ($this->sellIn <= 10) {
            $this->quality += 1;
        }

        if ($this->quality > self::MAX_QUALITY) {
            $this->quality = self::MAX_QUALITY;
        }
    }
}
