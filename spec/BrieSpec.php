<?php

use App\InventoryItem;
use App\GildedRose;

describe('Gilded Rose', function () {
    describe('next day', function () {
        context('Brie Items', function () {
            it('updates Brie items before the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BRIE, 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(11);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Brie items before the sell date with maximum quality', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BRIE, 50, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Brie items on the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BRIE, 10, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(12);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Brie items on the sell date, near maximum quality', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BRIE, 49, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Brie items on the sell date with maximum quality', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BRIE, 50, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Brie items after the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BRIE, 10, -10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(12);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
            it('updates Brie items after the sell date with maximum quality', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BRIE, 50, -10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
            it('is exempt from degrading', function () {
                $item = new InventoryItem(InventoryItem::BRIE, 0, 5);
                expect($item->doesDegrade())->toBe(false);
            });
        });
    });
});
