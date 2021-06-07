<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function path(): string
    {
        return '/books/' . $this->id;
    }


    public function checkout($user): void
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }


    /**
     * @throws Exception
     */
    public function checkin(User $user): void
    {
        $reservation = $this->reservations()->where('user_id', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if (is_null($reservation)) {
            throw new Exception();
        }

        $reservation->update([
            'checked_in_at' => now(),
        ]);
    }


    public function setAuthorIdAttribute($author): void
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author,
        ]))->id;
    }


    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
