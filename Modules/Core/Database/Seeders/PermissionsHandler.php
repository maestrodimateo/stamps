<?php
namespace Modules\Core\Database\Seeders;

use Exception;
use Illuminate\Support\Arr;
use Modules\Admin\Models\Module;
use Illuminate\Support\Collection;
use Modules\Admin\Models\Permission;

class PermissionsHandler
{
    /**
     * List the abilities
     *
     * @var Collection
     */
    protected Collection $abilities;

    /**
     * The targeted module
     *
     * @var array
     */
    protected array $module;

    /**
     * Get the permissions according to the path
     *
     * @param string $permissionPath
     *
     * @return self
     */
    public static function getFrom(string $permissionPath)
    {
        $permissionsModels = require $permissionPath;

        $permissionHandler = new self;

        $permissionHandler->abilities = collect(Arr::dot($permissionsModels['permissions']));
        $permissionHandler->module = $permissionsModels['module'];

        return $permissionHandler;
    }

    /**
     * Undocumented function
     *
     * @param array $abilities
     * @return self
     * @throws Exception
     */
    public function only(array $abilities): self
    {
        $filteredAbilities = $this->abilities->filter(
            function (string $value, string $key) use ($abilities) {
            return collect($abilities)->contains($key);
        });

        if ($filteredAbilities->isEmpty()) {
            throw new \Exception("Abilities not found", 1);

        }

        return $this;
    }

    /**
     * Create permissions for all the module's models
     *
     * @return Collection
     */
    public function create(): Collection
    {
        $module = Module::updateOrCreate($this->module);
        foreach ($this->abilities as $code => $label) {
            $permissions[] = [
                'code' => $code,
                'label' => $label,
            ];
        }

        $permissionsCreated = $module->permissions()->createMany($permissions);

        return $permissionsCreated->pluck(['id']);
    }

    /**
     * Get permissions
     *
     * @return array
     */
    public function get(): array
    {
        $permissionIds = [];

        foreach ($this->abilities as $code => $label) {
            $permissionIds[] = Permission::create([
                'code' => $code,
                'label' => $label,
            ])->id;
        }

        return $permissionIds;
    }
}
