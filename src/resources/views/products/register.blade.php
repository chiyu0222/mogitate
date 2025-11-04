<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>商品登録</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
<header class="mogitate-header">
    <h1 class="mogitate-logo">mogitate</h1>
</header>
  <div class="container">
    <h1>商品登録</h1>

    @if(session('success'))
      <div class="flash">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="field">
        <label>商品名 <span class="required">必須</span></label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
        @error('name')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>


      <div class="field">
        <label>値段 <span class="required">必須</span></label>
        <input type="text" name="price" value="{{ old('price') }}" placeholder="値段を入力">
        @error('price')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>


      <div class="field">
        <label>商品画像 <span class="required">必須</span></label>
        <input type="file" name="image" accept="image/*">
        @error('image')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>


      <div class="field">
        <label>季節 <span class="required">必須</span></label>
        <div class="seasons">
          <label><input type="checkbox" name="seasons[]" value="spring" {{ (is_array(old('seasons')) && in_array('spring', old('seasons'))) ? 'checked' : '' }}>春</label>
          <label><input type="checkbox" name="seasons[]" value="summer" {{ (is_array(old('seasons')) && in_array('summer', old('seasons'))) ? 'checked' : '' }}>夏</label>
          <label><input type="checkbox" name="seasons[]" value="autumn" {{ (is_array(old('seasons')) && in_array('autumn', old('seasons'))) ? 'checked' : '' }}>秋</label>
          <label><input type="checkbox" name="seasons[]" value="winter" {{ (is_array(old('seasons')) && in_array('winter', old('seasons'))) ? 'checked' : '' }}>冬</label>
        </div>
        @error('seasons')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>


      <div class="field">
        <label>商品説明 <span class="required">必須</span></label>
        <textarea name="description" rows="8" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
        @error('description')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>


      <div class="buttons">
        <button type="button" class="btn btn-back" onclick="history.back()">戻る</button>
        <button type="submit" class="btn btn-submit">登録</button>
      </div>
    </form>
  </div>
</body>
</html>
