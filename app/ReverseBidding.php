<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ReverseBidding extends Model implements HasMedia
{
    //
    use HasMediaTrait;

    protected $fillable= [
        'po_num',
        'user_id',
//        'name',//removed
        'description',
//        'quantity',
//        'days',
//        'duration',
        'expiration_time',
//        'asking_price',
//        'buying_price',
        'area',
        'delivery_address',
        'delivery_date_time',
        'category_id',
        'method',
        'status',
        'unit_of_measure',
    ];

    public function items()
    {
        return $this->hasMany(ReverseBiddingItems::class, 'reverse_bidding_id');
    }

    public function category()
    {
        return $this->belongsTo(MarketplaceCategories::class, 'category_id');
    }

    public function bids()
    {
        return $this->hasMany(ReverseBiddingBid::class, 'reverse_bidding_id')->orderBy('bid','asc');
    }

    public function offers()
    {
        return $this->hasMany(ReverseBiddingOffers::class, 'reverse_bidding_id')->orderBy('total_bid','asc');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getCurrentBidAttribute()
    {
        $bids = ReverseBiddingOffers::where('reverse_bidding_id', $this->id)->orderBy('total_bid','asc')->first();
        if($bids){
            $currentBid = $bids->total_bid;
            return $currentBid;
        }
    }

    public function getLowestBidAttribute()
    {
        return ReverseBiddingOffers::where('reverse_bidding_id', $this->id)->orderBy('total_bid','asc')->first();
    }

    public function getLowestBidUserAttribute()
    {
        $bids = ReverseBiddingOffers::where('reverse_bidding_id', $this->id)->orderBy('total_bid','asc')->first();
        $user = null;
        if($bids){
            $user = $bids->user;
        }
        return $user;
    }

    public function getWinnerAttribute()
    {
        $user = $this->getLowestBidUserAttribute();
        return $user;
    }

    public function getUserRankAttribute()
    {
        $bids = ReverseBiddingOffers::where('reverse_bidding_id', $this->id)
            ->orderBy('total_bid','asc')
            ->pluck('user_id')
            ->toArray();
        foreach($bids as $rank => $bid){
            if($bid == auth()->user()->id){
                return $rank + 1;
            }
        }
    }


    public function getIsExpiredAttribute()
    {
        return Carbon::parse($this->expiration_time)->isPast();
    }



    public function getUnitOfMeasureShortAttribute()
    {
        $uom = '';
        if($this['unit_of_measure']){
            switch ($this['unit_of_measure']){
                case 'kilos':
                    $uom = 'kg(s)';
                    break;
                case 'bayera':
                    $uom = ' bayera';
                    break;
                case 'lot':
                    $uom = ' lot';
                    break;
                case 'pieces':
                    $uom = 'pc(s)';
                    break;
                default:
                    $uom = $this['unit_of_measure'];
                    break;
            }
        }
        return $uom;
    }

}
