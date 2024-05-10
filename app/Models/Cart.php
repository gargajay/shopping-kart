<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $table = 'carts';
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public static function cartTotal(){
        $total = 0;
        $items =  self::where('user_id','=',Auth::id())->get();
        foreach($items as $item){
            $total += $item->qty * $item->product->price;
        }
        return $total;
    }

    public static function totalQty(){
       return Cart::where('user_id',Auth::id())->sum('qty');
    }
}
