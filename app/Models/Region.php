<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;


    public function parent() : BelongsTo
    {
        return $this->belongsTo(Region::class, 'parent_code', 'code');
    }

    public function children()
    {
        return $this->hasMany(Region::class, 'parent_code', 'code');
    }

    public function scopeRegency($query)
    {
        return $query->where('type', 'regency');
    }
    public function scopeProvinces($query)
    {
        return $query->where('type', 'Province');
    }
    public function scopeCities($query)
    {
        return $query->where('type', 'City');
    }
    public function scopeDistricts($query)
        {
            return $query->where('type', 'District');
        }
    public function scopeSubDistricts($query)
    {
        return $query->where('type', 'Sub-district');
    }
    

}