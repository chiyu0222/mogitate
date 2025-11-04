@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<header class="mogitate-header">
    <h1 class="mogitate-logo">mogitate</h1>
</header>

<main class="mogitate-main">
    <div class="product-card">
        <h2 class="page-title">
            <a href="{{ route('products') }}">商品一覧</a> ＞ {{ $product->name }}
        </h2>

        <form id="update-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="content-wrapper">

                <div class="product-image">
                    <label for="image">ファイルを選択</label><br>
                    <input type="file" id="imageInput" name="image" accept="image/png, image/jpeg">


                    <div id="imagePreview" class="image-preview" style="display:none;">
                        <img id="previewImg" src="#" alt="プレビュー画像">
                    </div>

                    @error('image')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>


                <div class="product-info">
                    <div class="form-group">
                        <label>商品名</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="商品名を入力">
                        @error('name') <p class="error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label>値段</label>
                        <input type="text" name="price" value="{{ old('price', $product->price) }}" placeholder="価格を入力">
                        @error('price') <p class="error">{{ $message }}</p> @enderror
                    </div>

            <div class="form-group">
                <label>季節</label>
                <div class="checkbox-group">
                    @foreach(['spring' => '春', 'summer' => '夏', 'autumn' => '秋', 'winter' => '冬'] as $key => $label)
                        <label class="checkbox-inline">
                            <input type="checkbox" name="seasons[]" value="{{ $key }}"
                                {{ in_array($key, old('seasons', explode(',', $product->season ?? ''))) ? 'checked' : '' }}>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>


                @error('seasons')
                    <p class="error">{{ $message }}</p>
                @enderror


                @if ($errors->has('seasons.*'))
                    <p class="error">{{ $errors->first('seasons.*') }}</p>
                @endif
            </div>


                    <div class="form-group">
                        <label>商品説明</label>
                        <textarea name="description" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="button-area">
    <a href="{{ route('products') }}" class="btn btn-secondary">戻る</a>


    <form id="update-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-primary">変更を保存</button>
    </form>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button">
            <img src="{{ asset('images/965_tr_h.svg') }}" alt="削除" class="trash-icon">
        </button>
    </form>
</div>
</main>
@endsection

@section('scripts')
<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        img.src = '#';
    }
});
</script>
@endsection
