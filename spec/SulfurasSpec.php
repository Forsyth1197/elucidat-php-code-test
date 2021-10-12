<?php

use App\InventoryItem;
use App\GildedRose;

describe('Gilded Rose', function () {
    describe('next day', function () {
        context('Sulfuras Items', function () {
            it('updates Sulfuras items before the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::SULFURAS, 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(10);
                expect($gr->getItem(0)->sellIn)->toBe(5);
            });
            it('updates Sulfuras items on the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::SULFURAS, 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(10);
                expect($gr->getItem(0)->sellIn)->toBe(5);
            });
            it('updates Sulfuras items after the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::SULFURAS, 10, -1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(10);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('is exempt from degrading', function () {
                $item = new InventoryItem(InventoryItem::SULFURAS, 0, 5);
                expect($item->doesDegrade())->toBe(false);
            });
        });
    });
});
