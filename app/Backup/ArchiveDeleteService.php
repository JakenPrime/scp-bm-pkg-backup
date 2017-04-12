<?php

namespace Packages\Backup\App\Backup;

use App\Api\ApiAuthService;
use Illuminate\Support\Collection;
use App\Support\Http\DeleteService;
use Packages\Backup\App\Backup\Events\ArchiveDeleted;

class ArchiveDeleteService extends DeleteService
{
    /**
     * @var ApiAuthService
     */
    protected $auth;

    /**
     * @param ApiAuthService $auth
     */
    public function boot(
        ApiAuthService $auth
    ) {
        $this->auth = $auth;
    }

    /**
     * @param Collection $items
     */
    protected function afterDelete(Collection $items)
    {
        $this->successItems('backup.archive.deleted', $items);
    }

    /**
     * @param Archive $item
     */
    protected function delete($item)
    {
        $this->checkCanDelete($item);
        $item->delete();
        $this->queue(new ArchiveDeleted($item));
    }

    /**
     * @param Archive $item
     */
    protected function checkCanDelete(Archive $item)
    {
        /* TODO: check status, throw Exception */

        if ($this->auth->is('admin')) {

        }
    }
}