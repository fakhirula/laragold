<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'city',
        'province',
        'head_id',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationship: Branch has many users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship: Get the branch head (user in charge)
     */
    public function head()
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    /**
     * Scope: Get only active branches
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get branches by city
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    /**
     * Scope: Get branches by province
     */
    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }

    /**
     * Helper method: Get branch info with head details
     */
    public function getHeadName(): ?string
    {
        return $this->head?->name ?? null;
    }

    /**
     * Helper method: Check if branch has a head assigned
     */
    public function hasHead(): bool
    {
        return $this->head_id !== null;
    }
}
