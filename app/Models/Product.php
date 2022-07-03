<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * @return string
     */
    public function presentPrice(): string
    {
        return 'E.P '.number_format($this->price / 100, 2);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeMightAlsoLike($query): mixed
    {
        return $query->inRandomOrder()->take(4);

    }
}
