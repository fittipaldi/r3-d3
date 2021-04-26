<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpacecraftArmament extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spacecraft_armament';

    /**
     * Get the user that owns the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spacecraft()
    {
        return $this->belongsTo(Spacecraft::class);
    }
}
