<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
{
    $favorites = Auth::user()->favorites;
    $item_ids = $favorites->pluck('item_id')->toArray();
    $items = Item::whereIn('id', $item_ids)->paginate(10);
    
    return view('item.index', compact('items', 'favorites'));
}

    public function store(Item $item)
    {
        Auth::user()->favorites()->create(['item_id' => $item->id]);

        return redirect()->back()->with('success', 'お気に入りに追加しました。');
    }

    public function destroy(Item $item)
    {
        $favorite = Auth::user()->favorites()->where('item_id', $item->id)->first();
        $favorite->delete();

        return redirect()->back()->with('success', 'お気に入りから削除しました。');
    }
}
