<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AccountListLayout extends Table
{
    public $target = 'Accounts';

    /**
     * @return \Orchid\Screen\TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', __('ID'))->width('150px'),
            TD::make('phone', __('Name'))->width('250px'),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Model $model) => DropDown::make()
                    ->icon('list')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('admin.accounts.edit', $model->{$model->getKeyName()})
                            ->icon('pencil'),
                    ])),
        ];
    }
}
