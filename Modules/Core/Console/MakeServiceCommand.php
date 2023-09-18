<?php

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Nwidart\Modules\Support\Config\GenerateConfigReader;

class MakeServiceCommand extends GeneratorCommand
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
    protected $name = 'module:make-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service the specific model';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the service.'],
            ['module', InputArgument::OPTIONAL, 'The name of the module that will be used.'],
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
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/service.stub', [
            'NAMESPACE'       => $this->getClassNamespace($module),
            'CLASS'           => $this->getClass(),
            'NAME'            => $this->getModelName(),
            'MODEL_NAMESPACE' => $this->getModelNamespace(),
            'REPOSITORY_NAMESPACE' => $this->getRepositoryNamespace(),
            'LOWER_NAME'      => $this->getModelLowerName(),
        ]))->render();
    }

    /**
     * Get repository namespace.
     *
     * @return string
     */
    public function getRepositoryNamespace(): string
    {
        return $this->laravel['modules']->config('namespace') . '\\' .
        $this->laravel['modules']->findOrFail($this->getModuleName()) . '\\' .
        $this->laravel['modules']->config('paths.generator.repositories.path', 'Repositories');
    }

    /**
     * @return mixed|string
     */
    private function getModelName()
    {
        return Str::studly(str_replace('Service', "", $this->argument('name')));
    }

    /**
     *Get the model lower name
     *
     * @return mixed|string
     */
    public function getModelLowerName()
    {
        return strtolower(Str::camel($this->getModelName()));
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $observerPath = GenerateConfigReader::read('service');

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
        return $this->laravel['modules']->config('namespace') . '\\' . $this->laravel['modules']->findOrFail($this->getModuleName()) . '\\' . $this->laravel['modules']->config('paths.generator.model.path', 'Models');
    }

    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.service.path', 'Services');
    }
}
