<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum TypeTransaction: string
{
    use Values;

    case STOCK_IN = 'stock_in';
    case STOCK_OUT = 'stock_out';
}
