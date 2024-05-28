<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account\AccountSteps;

use App\Models\Account;
use App\Models\AccountStep;
use App\Services\DomruService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Fields\Select;

class InitAccountStep
{
    public static function fields(Account $model): array
    {
        $options = DomruService::login($model->phone)
            ->keyBy('placeId')
            ->map(function(array $item) {
                return "{$item['placeId']} | {$item['accountId']} | {$item['address']}";
            });

        return [
            Select::make('model.place')
                ->options($options)
                ->title(__('Place')),
        ];
    }

    public static function process(Account $model, Request $request): void
    {
        $place = DomruService::login($model->phone)->firstWhere('placeId', $request->input('model.place'));

        $model->place = Arr::get($place, 'placeId');
        $model->operator = Arr::get($place, 'operatorId');
        $model->subscriber = Arr::get($place, 'subscriberId');
        $model->account = Arr::get($place, 'accountId');
        $model->address = Arr::get($place, 'address');
        $model->profile = Arr::get($place, 'profileId');

        $model->step = AccountStep::CODE;
        $model->save();

        DomruService::request($model);
    }
}
