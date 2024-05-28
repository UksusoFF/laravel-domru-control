<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account;

use App\Models\Account;

trait AccountRequestResolver
{
    protected function resolveAccount(): Account|null
    {
        /** @var \App\Models\Account|null $model */
        $model = request()->route()->parameter('model');

        return $model;
    }
}
