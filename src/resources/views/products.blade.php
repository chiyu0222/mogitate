@extends('layouts.app')

@section('title', '商品一覧')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
<style>
@section('styles')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection
</style>
@endsection

@section('content')
<header class="mogitate-header">
    <h1 class="mogitate-logo">mogitate</h1>
</header>
<div class="container">
    <h1>商品一覧</h1>

    <a href="{{ route('products.create') }}" class="add-button">＋商品を追加</a>


    <form action="{{ route('products') }}" method="GET" class="search-form">
        <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
        <select name="sort_price">
            <option value="">価格順</option>
            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>低い順</option>
            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>高い順</option>
        </select>
        <button type="submit">検索</button>
    </form>


    @if(request('sort_price'))
        <div class="sort-tag">
            並び替え：価格（{{ request('sort_price') == 'asc' ? '低い順' : '高い順' }}）
            <button type="button" onclick="resetSort()">×</button>
        </div>
    @endif


    <div class="product-list">
        @foreach($products as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->price }}円</p>
                </a>
            </div>
        @endforeach
    </div>


    <div class="pagination">
        {{ $products->links('vendor.pagination.custom') }}
    </div>
</div>


<script>
function resetSort() {
    const url = new URL(window.location.href);
    url.searchParams.delete('sort_price');
    window.location.href = url.toString();
}
</script>
@endsection
