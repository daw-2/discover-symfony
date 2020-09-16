<?php

namespace App\Model;

class Product
{
    public static $ai = 1;
    public $id;
    public $name;
    public $slug;
    public $price;

    public function __construct($name, $slug, $price)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->price = $price;

        $this->id = self::$ai++;
    }
}
