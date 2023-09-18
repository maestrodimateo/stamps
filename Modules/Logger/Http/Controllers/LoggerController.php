<?php

namespace Modules\Logger\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Logger\Http\Resources\LogResource;
use Modules\Logger\Models\Log;

/**
 * @group Logs management
 *
 */
class LoggerController extends Controller
{
    /**
     * get the 5 last logs
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        Gate::authorize('list-logs', auth()->user());

        $logs = Log::latest()->limit(10)->get();

        return LogResource::collection($logs);
    }
}
