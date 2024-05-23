<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function balance() {

        return $this->belongsTo(BalanceYear::class, 'balance_id','id');

    }

}
