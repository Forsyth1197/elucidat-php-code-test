<?php

use App\InventoryItem;
use App\GildedRose;

describe('Gilded Rose', function () {
    describe('next day', function () {
        context('Backstage Passes', function () {
            it('updates Backstage pass items long before the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 10, 11)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(11);
                expect($gr->getItem(0)->sellIn)->toBe(10);
            });
            it('updates Backstage pass items close to the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 10, 10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(12);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Backstage pass items close to the sell data, at max quality', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 50, 10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Backstage pass items very close to the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(13); // goes up by 3
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Backstage pass items very close to the sell date, at max quality', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 50, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Backstage pass items with one day left to sell', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 10, 1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(13);
                expect($gr->getItem(0)->sellIn)->toBe(0);
            });
            it('updates Backstage pass items with one day left to sell, at max quality', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 50, 1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(0);
            });
            it('updates Backstage pass items on the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 10, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Backstage pass items after the sell date', function () {
                $gr = new GildedRose([new InventoryItem(InventoryItem::BACKSTAGE_PASS, 10, -1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-2);
            });
            it('is exempt from degrading', function () {
                $item = new InventoryItem(InventoryItem::BACKSTAGE_PASS, 0, 5);
                expect($item->doesDegrade())->toBe(false);
            });
        });
    });
});
