<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payrolls';

    protected $primaryKey = 'payroll_id';

    protected $fillable = [
        'period_month',
        'period_year',
        'status',
    ];

}
