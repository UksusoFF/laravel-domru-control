<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account\AccountSteps;

use App\Models\Account;
use App\Models\AccountStep;
use App\Services\DomruService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Fields\Input;

class CodeAccountStep
{
    public static function fields(Account $model): array
    {
        return [
            Input::make('model.code')
                ->value($model->code)
                ->title(__('Code')),
        ];
    }

    public static function process(Account $model, Request $request): void
    {
        $model->code = $request->input('model.code');

        $model->save();

        $confirm = DomruService::confirm($model);

        $model->token = Arr::get($confirm, 'accessToken');
        $model->refresh = Arr::get($confirm, 'refreshToken');

        $model->step = AccountStep::EDIT;

        $model->save();
    }
}
