<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account\AccountSteps;

use App\Models\Account;
use App\Models\AccountStep;
use Illuminate\Http\Request;

class DefaultAccountStep
{
    public static function fields(Account $model): array
    {
        return [];
    }

    public static function process(Account $model, Request $request): void
    {
        $model->phone = $request->input('model.phone');

        $model->step = AccountStep::INIT;

        $model->save();
    }
}
