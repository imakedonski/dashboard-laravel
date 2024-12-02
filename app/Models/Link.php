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

    protected static function booted(): void
    {
        static::creating(function ($link) {
            $link->user_id = auth()->id();
        });
    }

    /**
     * @return array
     */
    public static function withPosition(): array
    {
        $links_array = array_fill(1, 9, null);
        $links = self::all()
            ->where('user_id', auth()->id())
            ->sortBy('position');
        if ($links) {
            foreach ($links as $link) {
                $links_array[$link->position] = $link;
            }
        }

        return $links_array;
    }
}
