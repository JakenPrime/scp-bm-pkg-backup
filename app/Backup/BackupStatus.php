<?php

namespace Packages\Backup\App\Backup;

interface BackupStatus
{
    /**
     * @var int
     */
    const QUEUED = 0;

    /**
     * @var int
     */
    const COMPRESS = 1;

    /**
     * @var int
     */
    const COPYING = 2;

    /**
     * @var int
     */
    const FINISHED = 4;

    /**
     * @var int
     */
    const FAILED = 10;
}
