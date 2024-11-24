<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'date',
        'description',
        'active',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        $categories = $this->belongsToMany(Category::class)
            ->select(array('id', 'name', 'active'))
            ->where('active', true);

        return $categories;
    }

    /**
     * @return Event[]|Collection
     */
    public function getEvents()
    {
        $events = Event::where('active', true)
            ->orderBy('date')
            ->get();

        return $events;
    }

    /**
     * Search in the name and body columns from the events table.
     *
     * @param string $search
     * @return array<string> searchEvents[]
     */
    public function searchEvents($search)
    {
        $searchEvents = Event::where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->pluck('name');

        return $searchEvents;
    }
}
