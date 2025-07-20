<?php

namespace App\Controllers\Items;

use App\Controllers\BaseController;
use App\Controllers\Items\ItemController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends ItemController
{
    public function __construct()
    {
        parent::__construct(true);
    }
}
