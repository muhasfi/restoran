<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $fillable = ['order_id', 
    'item_id', 
    'quantity', 
    'price', 
    'tax', 
    'total_price', 
    'created_at', 
    'updated_at'];
    protected $table = 'item.order_items';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
