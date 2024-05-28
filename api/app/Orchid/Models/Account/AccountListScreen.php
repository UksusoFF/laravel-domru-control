<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account;

use App\Models\Account;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class AccountListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'Accounts' => Account::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    public function layout(): iterable
    {
        return [
            AccountListLayout::class,
        ];
    }

    public function name(): ?string
    {
        return __('Accounts');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('admin.accounts.create'),
        ];
    }
}
