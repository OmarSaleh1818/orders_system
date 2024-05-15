<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project() {

        return $this->belongsTo(projects::class, 'project_id', 'id');

    }

}
