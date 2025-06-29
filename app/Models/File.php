<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class File extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'number',
        'description',
        'folder_id',
        'lawyer_id'
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class);
    }
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

     // Register media collection for files
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')->useDisk('public'); // use 'public' disk, you can change it
    }
}
