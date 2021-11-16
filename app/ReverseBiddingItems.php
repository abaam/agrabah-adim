<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReverseBiddingItems extends Model
{
    //
    protected $fillable = [
        'reverse_bidding_id',
        'item_name',
        'quantity',
        'unit_of_measure',
    ];

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
