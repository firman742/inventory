<?php

namespace App\Enums;

enum Table
{
    case users;
    case password_reset_tokens;
    case sessions;
    case jobs;
    case job_batches;
    case failed_jobs;
    case cache;
    case cache_locks;

    case products;
    case product_types;
    case stock_in_batches;
    case stock_outs;
    case serials;
    case transactions;
}
