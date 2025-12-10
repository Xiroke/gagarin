<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LunarMission extends Model
{
    protected $guarded = [];

    protected $hidden = ['id', 'crew_id', 'launch_site_id'];

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    public function launch_site()
    {
        return $this->belongsTo(LaunchSite::class);
    }
}
