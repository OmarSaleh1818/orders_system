<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesAttachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoice() {

        return $this->belongsTo(Invoices::class, 'invoice_id','id');

    }
}
