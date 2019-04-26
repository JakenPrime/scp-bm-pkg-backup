<?php

namespace Packages\Backup\App\Recurring;

use App\Api\ApiAuthService;
use App\Server\ServerRepository;
use App\Support\Http\FilterService;
use Illuminate\Database\Eloquent\Builder;

class RecurringFilterService extends FilterService
{
    /**
     * @var ApiAuthService
     */
    protected $auth;
    /**
     * @var ServerRepository
     */
    protected $servers;
    /**
     * @var RecurringListRequest
     */
    protected $request;

    protected $requestClass = RecurringListRequest::class;

    /**
     * @param ApiAuthService $auth
     * @param ServerRepository $servers
     */
    public function boot(
        ApiAuthService $auth,
        ServerRepository $servers
    ) {
        $this->auth    = $auth;
        $this->servers = $servers;
    }

    /**
     * @param Builder $query
     *
     * @throws \App\Api\Exceptions\ApiKeyNotFound
     * @throws \App\Auth\Exceptions\InvalidIpAddress
     */
    public function viewable(Builder $query)
    {
        $checkPerms = function () {
            if (!$this->permission->has('pkg.backup.read')) {
                abort(403, 'You do not have access to backups packages.');
            }
        };

        $this->auth->only([
            'admin' => $checkPerms,
            'integration' => $checkPerms,
        ]);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function query(Builder $query)
    {
        return $query;
    }
}
