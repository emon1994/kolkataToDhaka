<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemFile extends Model
{
    use HasFactory;

    protected $fillable = ['order_item_id', 'file_path'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
