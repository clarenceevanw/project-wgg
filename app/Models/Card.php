<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = ['title', 'image', 'description', 'users_id'];

    public function scopeFilter($query, array $filters) {
        if($filters['search'] ?? false){
            $query->where('title', 'like', '%' . request('search') . '%')
            ->orWhere('description', 'like', '%' . request('search') . '%');
        }
    }

    public function validationRules(): array {
        return [
            'title' => 'required|string|min:3',
            'description' => 'required|string'
        ];
    }

    public function validationMessages(): array {
        return[
            'title.required' => 'The title field is required',
            'title.string' => 'The title field must be a text',
            'title.min' => 'The title field must be at least 3 characters',
            'image.required' => 'The image field is required',
            'image.mime' => 'The image field must be a jpg, jpeg, or png file',
            'description.required' => 'The description field is required',
            'description.string' => 'The description field must be a text'
        ];
    }

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }
}
