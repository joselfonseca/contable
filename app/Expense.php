<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'payment_method_id',
        'date',
        'amount',
        'description'
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'payment_method_id' => 'integer'
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod() : BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeByLoggedInUser($query)
    {
        if (! request()->user()) {
            return $query;
        }
        return $query->where('user_id', request()->user()->id);
    }
}
