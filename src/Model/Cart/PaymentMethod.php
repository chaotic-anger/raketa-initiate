<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Model\Cart;


enum PaymentMethod: string
{
    case CARD = 'card';
    case CASH = 'cash';
}