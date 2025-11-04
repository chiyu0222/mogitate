<h2>“{{ $keyword }}”の商品一覧</h2>

<form action="{{ route('products.search') }}" method="GET">
    <input type="text" name="keyword" value="{{ $keyword }}">
    <button type="submit">検索</button>
</form>

<div class="sort">
    <label>価格順で表示</label>
    <select name="sort">
        <option>価格の低い順</option>
        <option>価格の高い順</option>
    </select>
</div>

<div class="product-list">
    @forelse($products as $product)
        <div class="product-item">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            <p>{{ $product->name }}</p>
            <p>¥{{ number_format($product->price) }}</p>
        </div>
    @empty
        <p>該当する商品が見つかりませんでした。</p>
    @endforelse
</div>
