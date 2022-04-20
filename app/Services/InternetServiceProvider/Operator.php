<?php

namespace App\Services\InternetServiceProvider;

abstract class Operator {  

    protected $month = 0;

    public function setMonth(int $month)
    {
        $this->month = $month;
    }

    abstract protected function calculateTotalAmount();
} 