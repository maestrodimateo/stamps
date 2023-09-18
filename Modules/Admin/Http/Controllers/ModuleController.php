<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Admin\Models\Module;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Admin\Http\Resources\ModuleResource;

/**
 * @group Admin management
 *
 */
class ModuleController extends Controller
{
    /**
     * Get all the modules
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        Gate::authorize('list-permissions', auth()->user());

        $modules = Module::with('permissions')->orderBy('title')->get();

        return ModuleResource::collection($modules);
    }
}
