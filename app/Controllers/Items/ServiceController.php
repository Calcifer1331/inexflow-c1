<?php

namespace App\Controllers\Items;

use App\Controllers\Items\ItemController;

class ServiceController extends ItemController
{
    public function __construct()
    {
        parent::__construct(false);
    }
}
