<?php

namespace Packages\Backup\App\Backup\Recurring;

use App\Database\Models\Model;
use Illuminate\Database\Eloquent;
use Packages\Backup\App\Backup;

class Recurring
extends Model
{
    use Backup\Backupable;

    public $table = 'pkg_backup_recurring_backups';

    /**
     * @param Eloquent\Builder $query
     *
     * @return Eloquent\Builder
     */
    public function scopeReady(Eloquent\Builder $query)
    {
        $dateTime = app(\App\DatetimeService::class);
        $date = $dateTime->now()->format(
            $dateTime->databaseFormat()
        );

        return $this
            ->scopeJoinLatest($query)
            ->addSelect('pkg_backup_recurring_backups.*')
            ->groupBy('pkg_backup_recurring_backups.id')
            ->havingRaw('latest_date IS NULL')
            ->orHaving(
                \DB::raw('latest_date'), '<=',
                \DB::raw(
                    "'$date' - INTERVAL $this->table.period SECOND"
                )
            )
            ;
    }

    /**
     * @param Eloquent\Builder $query
     * @param string           $joinType
     * @param string           $alias
     *
     * @return Eloquent\Builder
     */
    public function scopeJoinLatest(
        Eloquent\Builder $query,
        $joinType = 'left',
        $alias = 'latest',
        $date = 'latest_date'
    ) {
        return $query
            ->addSelect(\DB::raw("MAX($alias.created_at) as $date"))
            ->join(
                "pkg_backup_backups as $alias",
                "$alias.recurring_id",
                '=',
                "$this->table.id",
                $joinType
            )
            ;
    }
}