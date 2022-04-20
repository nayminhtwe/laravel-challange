<?php

namespace App\Services\InternetServiceProvider;

class Ooredoo extends Operator
{
    protected $operator = 'ooredoo';
    
    protected $monthlyFees = 150;
    
    public function calculateTotalAmount()
    {
        return $this->month * $this->monthlyFees;
    }
    
}