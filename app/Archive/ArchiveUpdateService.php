<?php

namespace Packages\Backup\App\Archive;

use App\Api\ApiAuthService;
use Illuminate\Support\Collection;
use App\Support\Http\UpdateService;

class ArchiveUpdateService extends UpdateService
{
    /**
     * @var ApiAuthService
     */
    protected $auth;

    /**
     * @var ArchiveFormRequest
     */
    protected $request;

    /**
     * @var string
     */
    protected $requestClass = ArchiveFormRequest::class;

    public function boot(ApiAuthService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Archive $item
     */
    public function fillData(Archive $item)
    {
        $item->source_id      = $this->request->input('source.id');
        $item->destination_id = $this->request->input('destination.id');
        $item->recurring_id   = $this->request->input('recurring.id');
    }

    /**
     * @param Collection $items
     */
    public function afterCreate(Collection $items)
    {
        $createEvent = $this->queueHandler(Events\ArchiveCreated::class);

        $this->successItems('pkg.backup::backup.archive.created', $items->each($createEvent));
    }

    /**
     * Update all archives using the given request.
     *
     * @param Collection $items
     */
    public function updateAll(Collection $items)
    {
        if ($this->create) {
            $items->map([$this, 'fillData']);
        }
    }
}