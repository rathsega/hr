<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory_item extends Model
{
    use HasFactory;

    public function assigned_user() {
        return $this->belongsTo(User::class, 'assigned_user_id')->withDefault();
    }
    public function responsible_user() {
        return $this->belongsTo(User::class, 'responsible_user_id')->withDefault();
    }
    public function branch() {
        return $this->belongsTo(Branch::class)->withDefault();
    }
}
