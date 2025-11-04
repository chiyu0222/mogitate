<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\Product::query();
    // キーワード検索
    if ($keyword = $request->input('keyword')) {
        $query->where('name', 'like', "%{$keyword}%");
    }

    // 価格順ソート
    if ($sort_price = $request->input('sort_price')) {
        $query->orderBy('price', $sort_price);
    }

    $products = $query->paginate(6);

    return view('products', compact('products'));
}


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::where('name', 'like', "%{$keyword}%")->get();

        return view('products.search', compact('products', 'keyword'));
    }

    public function show($productId)
{
    $product = Product::findOrFail($productId);
    return view('products.show', compact('product'));
}

    public function create()
    {
        return view('products.register');
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|between:0,10000',
        'image' => 'required|mimes:png,jpeg|max:2048',
        'seasons' => 'required|array',
        'seasons.*' => 'in:spring,summer,autumn,winter',
        'description' => 'required|string|max:120',
    ], [

        'name.required' => '商品名を入力してください',


        'price.required' => '値段を入力してください',
        'price.numeric' => '数値で入力してください',
        'price.between' => '0~10000円以内で入力してください',


        'seasons.required' => '季節を選択してください',


        'description.required' => '商品説明を入力してください',
        'description.max' => '120文字以内で入力してください',


        'image.required' => '商品画像を登録してください',
        'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
    ]);



    $path = $request->file('image')->store('products', 'public');

    $seasonString = implode(',', $validated['seasons']);



    $product = new \App\Models\Product();
    $product->name = $validated['name'];
    $product->price = $validated['price'];
    $product->image = $path;
    $product->season = implode(',', $validated['seasons']); // 複数季節対応
    $product->description = $validated['description'];
    $product->save();

    return redirect()->route('products')
        ->with('success', '商品を登録しました！');
}


public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('products')->with('success', '商品を削除しました');
}
public function update(Request $request, Product $product)
{

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,10000',
            'image' => 'required|mimes:png,jpeg|max:2048', // ←ここ変更
            'seasons' => 'required|array|min:1',
            'seasons.*' => 'in:spring,summer,autumn,winter',
            'description' => 'required|string|max:120',
        ], [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'seasons.min' => '季節を1つ以上選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を選択してください', // ←追加
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ]);

    // 画像更新
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }

    // 他のフィールド更新
    $product->name = $validated['name'];
    $product->price = $validated['price'];
    $product->description = $validated['description'];
    $product->season = implode(',', $validated['seasons']); // 一度だけ代入

    $product->save();

    return redirect()->route('products')
        ->with('success', '商品情報を更新しました！');
}

}
