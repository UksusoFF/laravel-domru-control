<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account;

use App\Models\Account;
use App\Models\AccountStep;
use App\Orchid\Models\Account\AccountSteps\CodeAccountStep;
use App\Orchid\Models\Account\AccountSteps\DefaultAccountStep;
use App\Orchid\Models\Account\AccountSteps\EditAccountStep;
use App\Orchid\Models\Account\AccountSteps\InitAccountStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class AccountEditScreen extends Screen
{
    use AccountRequestResolver;

    public function query(Account $model): iterable
    {
        return [
            'model' => $model,
        ];
    }

    public function name(): ?string
    {
        return __('Accounts');
    }

    public function commandBar(): iterable
    {
        $step = $this->resolveAccount()?->step;

        return match ($step) {
            null,
            AccountStep::INIT,
            AccountStep::CODE => [
                Button::make(__('Next'))->icon('arrow-right')->method('save'),
            ],
            AccountStep::EDIT => [],
        };
    }

    public function layout(): iterable
    {
        return [
            AccountEditLayout::class,
        ];
    }

    public function save(Account $model, Request $request): RedirectResponse
    {
        match ($model->step) {
            null => DefaultAccountStep::process($model, $request),
            AccountStep::INIT => InitAccountStep::process($model, $request),
            AccountStep::CODE => CodeAccountStep::process($model, $request),
            AccountStep::EDIT => EditAccountStep::process($model, $request),
        };

        Toast::info(__('Model was saved'));

        return redirect()->route('admin.accounts.edit', $model->id);
    }

    public function delete(Account $model): RedirectResponse
    {
        Toast::info(__('Action not allowed'));

        return redirect()->route('admin.accounts');
    }
}
