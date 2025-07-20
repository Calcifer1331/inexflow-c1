<?php

namespace App\Models;

use App\Entities\InventoryMovement;
use CodeIgniter\Model;

class InventoryMovementsModel extends Model
{
    protected $table            = 'inventory_movements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = InventoryMovement::class;


    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
