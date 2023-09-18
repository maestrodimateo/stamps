<?php

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Nwidart\Modules\Commands\ControllerMakeCommand as CommandsControllerMakeCommand;

class ControllerMakeCommand extends CommandsControllerMakeCommand
{
    use ModuleCommandTrait;

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME'        => $module->getStudlyName(),
            'CONTROLLERNAME'    => $this->getControllerName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => class_basename($this->getControllerName()),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
            'MODEL_NAMESPACE'   => $this->getModelNamespace(),
            'MODEL_NAME'        => $this->getModelName(),
            'MODEL_LOWER_NAME'  => $this->getModelLowerName(),
            'SERVICE_NAMESPACE' => $this->getServiceNamespace(),
            'REQUEST_NAMESPACE' => $this->getRequestNamespace(),
            'RESOURCE_NAMESPACE'=> $this->getResourceNamespace(),
        ]))->render();
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

    /**
     * @return mixed|string
     */
    private function getModelName()
    {
        return Str::studly(str_replace('Controller', "", $this->argument('controller')));
    }

    /**
     * @requires string
     *
     * @return void
     */
    public function getModelLowerName()
    {
        return strtolower(Str::camel($this->getModelName()));
    }

    /**
     * Get service namespace.
     *
     * @return string
     */
    public function getServiceNamespace(): string
    {
        return $this->laravel['modules']->config('namespace') . '\\' .
        $this->laravel['modules']->findOrFail($this->getModuleName()) . '\\' .
        $this->laravel['modules']->config('paths.generator.services.path', 'Services');
    }

    /**
     * Get resource namespace.
     *
     * @return string
     */
    public function getResourceNamespace(): string
    {
        $namespace = str_replace('/', "\\", $this->laravel['modules']->config('paths.generator.resource.path', 'Resources'));
        return $this->laravel['modules']->config('namespace') . '\\' . $this->laravel['modules']->findOrFail($this->getModuleName()) . '\\' . $namespace;
    }

    /**
     * Get request namespace.
     *
     * @return string
     */
    public function getRequestNamespace(): string
    {
        $namespace = str_replace('/', "\\", $this->laravel['modules']->config('paths.generator.request.path', 'Requests'));
        return $this->laravel['modules']->config('namespace') . '\\' . $this->laravel['modules']->findOrFail($this->getModuleName()) . '\\' . $namespace;
    }
}
