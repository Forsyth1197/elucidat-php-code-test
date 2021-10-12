<?php

use App\InventoryItem;
use App\GildedRose;

describe('Gilded Rose', function () {
    describe('next day', function () {
        context('normal Items', function () {
            it('updates normal items before sell date', function () {
                $gr = new GildedRose([new InventoryItem('normal', 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(9);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates normal items on the sell date', function () {
                $gr = new GildedRose([new InventoryItem('normal', 10, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(8);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates normal items after the sell date', function () {
                $gr = new GildedRose([new InventoryItem('normal', 10, -5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(8);
                expect($gr->getItem(0)->sellIn)->toBe(-6);
            });
            it('updates normal items with a quality of 0', function () {
                $gr = new GildedRose([new InventoryItem('normal', 0, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('is not exempt from degrading', function () {
                $item = new InventoryItem('normal', 0, 5);
                expect($item->doesDegrade())->toBe(true);
            });
        });
    });
});
