<?php

declare(strict_types=1);

namespace App\Orchid\Models\Account\AccountSteps;

use App\Models\Account;
use App\Services\DomruService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;

class EditAccountStep
{
    public static function fields(Account $model): array
    {
        $place = DomruService::places($model)->firstWhere('place.id', $model->place);
        $controls = Arr::get($place, 'place.accessControls', []); // TODO: Если пусто - авторизовывать заново
        $cameras = DomruService::cameras($model);

        $fields = [
            Input::make('model.token')
                ->value($model->token)
                ->title(__('Token')),

            Input::make('model.refresh')
                ->value($model->refresh)
                ->title(__('Refresh')),
        ];

        foreach ($controls as $control) {
            $controlId = Arr::get($control, 'id');

            $fields[] = Group::make([
                Input::make('model.control.id')
                    ->value($controlId)
                    ->title(__('Control ID'))
                    ->readonly()
                    ->disabled(),
                Input::make('model.control.open')
                    ->value(route('place.open', [
                        'account' => $model,
                        'control' => $controlId,
                    ]))
                    ->title(__('Control open'))
                    ->readonly()
                    ->disabled(),
                Input::make('model.control.snap')
                    ->value(route('place.snap', [
                        'account' => $model,
                        'control' => $controlId,
                    ]))
                    ->title(__('Control snap'))
                    ->readonly()
                    ->disabled(),
            ]);
        }

        foreach ($cameras as $camera) {
            $cameraId = Arr::get($camera, 'ID');

            $fields[] = Group::make([
                Input::make('model.camera.id')
                    ->value($cameraId)
                    ->title(__('Camera ID'))
                    ->readonly()
                    ->disabled(),
                Input::make('model.camera.rtsp')
                    ->value(route('camera.rtsp', [
                        'account' => $model,
                        'camera' => $cameraId,
                    ]))
                    ->title(__('Camera RTSP'))
                    ->readonly()
                    ->disabled(),
            ]);
        }

        return $fields;
    }

    public static function process(Account $model, Request $request): void
    {
        //
    }
}
