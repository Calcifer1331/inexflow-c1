<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryMovementsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'business_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'item_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'transaction_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => true,
                'comment'    => 'NULL para movimientos manuales (ajustes de inventario)'
            ],
            'movement_type' => [
                'type'       => 'ENUM',
                'constraint' => ['in', 'out', 'adjustment'],
                'null'       => false,
                'comment'    => 'in=entrada (compra), out=salida (venta), adjustment=ajuste manual'
            ],
            'quantity' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => false,
                'comment'    => 'Cantidad del movimiento (positiva para entradas, negativa para salidas)'
            ],
            'unit_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'comment'    => 'Costo unitario del producto en el momento del movimiento'
            ],
            'unit_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'comment'    => 'Precio de venta unitario (para salidas)'
            ],
            'total_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'comment'    => 'Costo total del movimiento'
            ],
            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'comment'    => 'Monto total de venta (para salidas)'
            ],
            'stock_before' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => false,
                'comment'    => 'Stock antes del movimiento'
            ],
            'stock_after' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => false,
                'comment'    => 'Stock después del movimiento'
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Notas adicionales sobre el movimiento'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Índices para optimizar consultas
        $this->forge->addKey(['business_id', 'item_id']);
        $this->forge->addKey(['business_id', 'created_at']);
        $this->forge->addKey('transaction_id');

        // Foreign keys
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('item_id', 'items', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('inventory_movements');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_movements');
    }
}
