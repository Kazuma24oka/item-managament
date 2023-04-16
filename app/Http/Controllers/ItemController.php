<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        // 検索機能
        $search = $request->input('search');
        $keywords = [];
        if (!empty($search)) {
            $keywords = preg_split('/\s+/', $search);
        }
    
        $query = Item::query()->where('items.status', 'active');
        foreach ($keywords as $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->orWhere('items.name', 'like', '%' . $keyword . '%')
                    ->orWhere('items.id', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('items.type', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('items.detail', 'like', '%' . $keyword . '%');
            });
        }
        // ソート機能
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $query->orderBy($sort, $order);
    
        // ページネーションを適用（ページあたりのアイテム数を15に設定）
        $items = $query->paginate(15);
    
        return view('item.index', compact('items', 'search', 'sort', 'order'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'type' => 'nullable',
                'detail' => 'nullable|max:500',
                'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // 画像ファイルが存在するかチェック
            if ($request->hasFile('file')) {
                // Cloudinaryへのアップロード
                $image = $request->file('file');
                $uploaded = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'your_folder_name',
                ])->getSecurePath();

                // 画像のURLを保存
                $publicPath = $uploaded;
            } else {
                // 画像が存在しない場合、デフォルトの画像パスを保存
                $publicPath = 'https://res.cloudinary.com/dkrwjahga/image/upload/v1681621150/No_image_tftpwv.png';
            }

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'image' => $publicPath,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }

    /**
     * 商品編集
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('item.update', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:100',
            'file' => 'nullable|image',
            'type' => 'nullable|integer|min:1|max:6',
            'detail' => 'nullable|max:500',
        ]);

        if ($request->file('file')) {
            // Cloudinaryへのアップロード
            $image = $request->file('file');
            $uploaded = Cloudinary::upload($image->getRealPath(), [
                'folder' => 'your_folder_name',
            ])->getSecurePath();

            // 画像のURLを保存
            $publicPath = $uploaded;
            $item->image = $publicPath;
        }

        $item->name = $request->name;
        $item->type = $request->type;
        $item->detail = $request->detail;
        $item->save();

        return redirect('/items');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $item->delete();
            return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
    
}
