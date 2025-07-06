<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Symfony\Component\Translation\Test\IncompleteDsnTestTrait;

class Loan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function loan_documents()
    {
        return $this->hasMany(LoanDocument::class, 'loan_id');
    }
    public function repayments()
    {
        return $this->hasMany(Repayment::class, 'loan_id');
    }

    public function next_repayment()
    {
        return $this->hasOne(Repayment::class, 'loan_id')
            ->where('status', 'pending')
            ->orderBy('installment_number', 'ASC');
    }

}
