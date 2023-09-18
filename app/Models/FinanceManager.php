<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceManager extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applicant() {

        return $this->belongsTo(Applicant::class, 'applicant_id','id');

    }

}
