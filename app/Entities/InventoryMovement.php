<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class InventoryMovement extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'item_id' => 'uuid',
        'transaction_id' => 'uuid',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];
    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
