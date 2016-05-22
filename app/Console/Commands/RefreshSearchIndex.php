<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\SearchIndex\Searchable;

class RefreshSearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:refresh-index {model : The type of entity to refresh. e.g. "\App\Product"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete and re-index the entities for searching';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modelName = $this->argument('model');

        if (!class_exists($modelName) or !($model = new $modelName()) instanceof Searchable) {
            $this->error(sprintf('%s is not a searchable model.', $modelName));

            return;
        }

        $this->info('Updating models in the index...');

        $models = $model::all();
        $bar = $this->output->createProgressBar($models->count());

        $models->each(function ($entity) use ($bar) {
            \SearchIndex::upsertToIndex($entity);

            $bar->advance();
        });

        $this->info(sprintf(PHP_EOL.'%s entities refreshed.', $models->count()));
    }
}
