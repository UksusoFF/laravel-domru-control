<?php

declare(strict_types=1);

namespace App\Orchid\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ModelCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'orchid:model {source} {target}';

    protected $description = 'Generate a new model section from source';

    protected const NAMESPACE = 'Orchid/Models';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $from = trim($this->argument('source'));
        $to = trim($this->argument('target'));

        foreach(glob($this->getDirectory($from).'*.php') as $stub) {
            $source = $stub;
            $target = Str::replace($from, $to, $source);

            $this->makeDirectory($this->getDirectory($to));

            $this->files->copy($source, $target);
            $this->replaceContent($from, $to, $target);
        }

        return self::SUCCESS;
    }

    protected function getDirectory($name): string
    {
        return app_path(self::NAMESPACE.'/'.$name.'/');
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    protected function replaceContent(string $from, string $to, string $target): void
    {
        $this->files->replaceInFile($from, $to, $target);
        $this->files->replaceInFile(Str::snake($from, '-'), Str::snake($to, '-'), $target);
        $this->files->replaceInFile(Str::snake($from, '.'), Str::snake($to, '.'), $target);
        $this->files->replaceInFile(Str::title(Str::snake($from, ' ')), Str::title(Str::snake($to, ' ')), $target);
    }
}
