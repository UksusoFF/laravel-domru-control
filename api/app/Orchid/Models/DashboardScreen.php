<?php

declare(strict_types=1);

namespace App\Orchid\Models;

use Illuminate\Support\Collection;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class DashboardScreen extends Screen
{
    protected function getMetrics(): Collection
    {
        return collect();
    }

    public function query(): iterable
    {
        return [
            'metrics' => [],
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::metrics([]),
        ];
    }

    public function name(): ?string
    {
        return __('Dashboard');
    }
}
