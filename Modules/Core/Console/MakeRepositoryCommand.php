<?php

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Nwidart\Modules\Support\Config\GenerateConfigReader;

class MakeRepositoryCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'module:make-repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository the specific model';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository.'],
            ['module', InputArgument::OPTIONAL, 'The name of the module that will be used.'],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/repository.stub', [
            'NAMESPACE'       => $this->getClassNamespace($module),
            'CLASS'           => $this->getClass(),
            'NAME'            => $this->getModelName(),
            'MODEL_NAMESPACE' => $this->getModelNamespace(),
        ]))->render();
    }

    /**
     * Get repository namespace.
     *
     * @return string
     */
    public function getRepositoryNamespace(): string
    {
        return $this->laravel['modules']->config('namespace')
        .'\\' . $this->laravel['modules']->findOrFail($this->getModuleName())
        . '\\' . $this->laravel['modules']->config('paths.generator.repositories.path', 'Repositories');
    }

    /**
     * @return mixed|string
     */
    private function getModelName()
    {
        return Str::studly(str_replace('Repository', "", $this->argument('name')));
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $observerPath = GenerateConfigReader::read('repository');

        return $path . $observerPath->getPath() . '/' . $this->getFileName();
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name')) . '.php';
    }

    /**
     * Get model namespace.
     *
     * @return string
     */
    public function getModelNamespace(): string
    {
        return $this->laravel['modules']->config('namespace') . '\\' .
        $this->laravel['modules']->findOrFail($this->getModuleName()) . '\\' .
        $this->laravel['modules']->config('paths.generator.model.path', 'Models');
    }

    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.repository.path', 'Repositories');
    }
}
