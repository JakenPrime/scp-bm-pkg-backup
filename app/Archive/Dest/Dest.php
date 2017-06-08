<?php

namespace Packages\Backup\App\Archive\Dest;

use App\Database\Models\Model;
use Packages\Backup\App\Archive;

class Dest
extends Model
implements Archive\Field\HasValues
{
    public $table = 'pkg_backup_destinations';

    public static $singular = 'Destination';
    public static $plural = 'Destinations';

    /**
     * @return Relations\MorphMany
     */
    public function fieldValues()
    {
        return $this->morphMany(Archive\Field\Value::class, 'parent');
    }

    /**
     * @return Relations\BelongsTo
     */
    public function handler()
    {
        return $this->belongsTo(Archive\Handler\Handler::class);
    }
}
