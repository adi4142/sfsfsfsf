<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\JobApplicant;
use App\Selection;

class SelectionApplicant extends Model
{
    protected $table = 'selection_applicants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'selection_id',
        'job_applicant_id',
        'score',
        'notes',
        'status',
    ];

    public function jobapplicant()
    {
        return $this->belongsTo(JobApplicant::class, 'job_applicant_id', 'job_applicant_id');
    }   

    public function selection()
    {
        return $this->belongsTo(Selection::class, 'selection_id', 'selection_id');
    }
}
