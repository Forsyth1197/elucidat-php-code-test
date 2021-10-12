<?php

use App\InventoryItem;
use App\GildedRose;

describe('Gilded Rose', function () {
    describe('next day', function () {
        context("Conjured Items", function () {
            it('updates Conjured items before the sell date', function () {
                $gr = new GildedRose([new InventoryItem('Conjured Mana Cake', 10, 10, true)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(8);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Conjured items at zero quality', function () {
                $gr = new GildedRose([new InventoryItem('Conjured Mana Cake', 0, 10, true)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Conjured items on the sell date', function () {
                $gr = new GildedRose([new InventoryItem('Conjured Mana Cake', 10, 0, true)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(6);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Conjured items on the sell date at 0 quality', function () {
                $gr = new GildedRose([new InventoryItem('Conjured Mana Cake', 0, 0, true)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Conjured items after the sell date', function () {
                $gr = new GildedRose([new InventoryItem('Conjured Mana Cake', 10, -10, true)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(6);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
            it('updates Conjured items after the sell date at zero quality', function () {
                $gr = new GildedRose([new InventoryItem('Conjured Mana Cake', 0, -10, true)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
        });
    });
});
