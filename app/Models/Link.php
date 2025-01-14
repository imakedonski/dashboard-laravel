<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'color_id',
        'url',
        'position',
    ];

    /**
     * Define the color relationship.
     *
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * @return array
     */
    public static function withPosition()
    {
        $links_array = array_fill(1, 9, null);
        $links = self::all()->load('color')->sortBy('position');
        if ($links) {
            foreach ($links as $link) {
                $links_array[$link->position] = $link;
            }
        }

        return $links_array;
    }

    /**
     * Checks if the current link belongs to a certain user
     *
     * @param int|null $user_id
     * @return bool
     */
    public function ownedBy(?int $user_id = null): bool
    {
        return auth()->id() === $this->user_id;
    }
}
