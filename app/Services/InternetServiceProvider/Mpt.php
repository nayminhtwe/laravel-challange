<?php

namespace App\Services\InternetServiceProvider;

class Mpt extends Operator
{
    protected $operator = 'mpt';
    
    protected $monthlyFees = 200;

    public function calculateTotalAmount()
    {
        return $this->month * $this->monthlyFees;
    }
    
}