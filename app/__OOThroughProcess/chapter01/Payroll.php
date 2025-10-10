<?php

namespace App\__OOThroughProcess\chapter01;

use PhpParser\Node\Expr\Cast\Double;

class Payroll
{
    private double $pay;
    public function calculatePay() : double
    {
        return $this->pay;
    }
}
