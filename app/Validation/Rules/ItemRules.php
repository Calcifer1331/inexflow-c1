<?php

namespace App\Validation\Rules;

use App\Models\ItemModel;

class ItemRules
{
    protected $model;

    public function __construct()
    {
        $this->model = new ItemModel();
    }

    public function no_overflow_stock(int $quantity)
    {
        return true;
    }
}
