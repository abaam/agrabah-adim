<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReverseBiddingOffers extends Model
{
    //
    protected $fillable = [
        'reverse_bidding_id',
        'user_id',
        'gross_total',
        'service_fee',
        'vat',
        'total_bid',
        'bids',
        'agree_on',
    ];

    public function po()
    {
        return $this->belongsTo(ReverseBidding::class, 'reverse_bidding_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
