<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account;

use App\Models\AccountStep;
use App\Orchid\Models\Account\AccountSteps\CodeAccountStep;
use App\Orchid\Models\Account\AccountSteps\DefaultAccountStep;
use App\Orchid\Models\Account\AccountSteps\EditAccountStep;
use App\Orchid\Models\Account\AccountSteps\InitAccountStep;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class AccountEditLayout extends Rows
{
    use AccountRequestResolver;

    public function fields(): array
    {
        return array_merge([
            Select::make('model.step')
                ->fromEnum(AccountStep::class)
                ->disabled()
                ->title(__('Step')),

            Input::make('model.phone')
                ->title(__('Phone')),
        ], $this->stepFields());
    }

    protected function stepFields(): array
    {
        $model = $this->resolveAccount();

        if ($model === null) {
            return [];
        }

        return match ($model->step) {
            null => DefaultAccountStep::fields($model),
            AccountStep::INIT => InitAccountStep::fields($model),
            AccountStep::CODE => CodeAccountStep::fields($model),
            AccountStep::EDIT => EditAccountStep::fields($model),
        };
    }
}
