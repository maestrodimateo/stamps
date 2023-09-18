<?php

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FeatureMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'module:make-feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all the necessary files for a model';

    /**
     * All the commands that will be executed
     *
     * @return array
     */
    protected function commands()
    {
        $model  = Str::studly($this->argument('model'));
        $module = Str::studly($this->argument('module'));

        $withApiController = $this->option('api') ? '--api' : '';

        return [
            "module:make-model {$model} {$module} -m",
            "module:make-controller {$model}Controller {$module} $withApiController",
            "module:make-resource {$model}Resource {$module}",
            "module:make-request {$model}Request {$module}",
            "module:make-policy {$model}Policy {$module}",
            "module:make-repository {$model}Repository {$module}",
            "module:make-service {$model}Service {$module}",
        ];
    }

    /**
     * Execute all the commands
     *
     * @return bool
     */
    protected function executes()
    {
        $commands = $this->commands();

        foreach ($commands as $command) {
            $this->line("<fg=yellow>Executing: </>[$command]");
            Artisan::call($command);
            $this->line("<fg=green>Executed: </>[$command]");
        }
        return true;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->executes()) {
            $this->info('Feature successfully created!');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'The model tp create the feature for.'],
            ['module', InputArgument::REQUIRED, 'The name of module will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['api', null, InputOption::VALUE_NONE, 'to include a restfull controller'],
        ];
    }
}
