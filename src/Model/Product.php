<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Product
{
    public static $ai = 1;
    public $id;

    /**
     * @Assert\NotBlank
     */
    public $name;
    public $slug;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    public $description;
    public $price;

    public function __construct($name = null, $description = null, $slug = null, $price = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->slug = $slug;
        $this->price = $price;

        $this->id = self::$ai++;
    }
}
