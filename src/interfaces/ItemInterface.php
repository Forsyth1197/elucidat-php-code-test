<?php

namespace App\Interfaces;

interface ItemInterface
{
    public function handle();
    public function doesDegrade();
    public function decreaseSellIn();
}
