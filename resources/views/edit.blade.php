<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">
            <h1>商品情報編集画面</h1>
        </div>
        <div class="edit_container">
            <table>
                <tbody>
                    <tr>
                        <th class="update_title">ID</th>
                        <th class="detail_box">{{ $product -> id }}.</th>
                    </tr>
                    <form action=" {{ route('update', ['id'=>$product->id]) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        <tr>
                            <th class="update_title"><label for="product_name">商品名<span class="required"
                                        style="color:red">*</span></label></th>
                            <th><input type="text" name="product_name" id="product_name"
                                    value="{{ old('product_name', $product -> product_name ) }}" class="update_box">
                                @if ($errors -> has('product_name'))
                                <p class="error">{{ $errors->first('product_name') }}</p>
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th class="update_title"><label for="company_id">メーカー名<span class="required"
                                        style="color:red">*</span></label></th>
                            <th><select name="company_id" id="company_id" class="update_box">
                                @foreach ($companies as $company)
                                    <option value="{{ $product->company_id}}" hidden>{{ $product->company->company_name }}</option>
                                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors -> has('company_id'))
                                <p class="error">{{ $errors->first('company_id') }}</p>
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th class="update_title"><label for="price">価格<span class="required"
                                        style="color:red">*</span></label></th>
                            <th><input type="number" name="price" id="price" step="10"
                                    value="{{ old('price', $product -> price) }}" class="update_box">
                                @if ($errors -> has('price'))
                                <p class="error">{{ $errors->first('price') }}</p>
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th class="update_title"><label for="stock">在庫数<span class="required"
                                        style="color:red">*</span></label></th>
                            <th><input type="number" name="stock" id="stock" value="{{ old('stock', $product -> stock) }}"
                                    class="update_box">
                                @if ($errors -> has('stock', $product -> stock))
                                <p class="error">{{ $errors->first('stock') }}</p>
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th class="update_title"><label for="comment">コメント</label></th>
                            <th><textarea name="comment" id="comment" cols="30" rows="2"
                                    class="update_box">{{ old('comment', $product -> comment) }}</textarea>
                                @if ($errors -> has('comment'))
                                <p class="error">{{ $errors->first('comment') }}</p>
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th class="update_title"><label for="img_path">商品画像</label></th>
                            <th><input type="file" name="img_path" id="img_path" class="add_img"></th>
                        </tr>

                </tbody>
            </table>
            <div class="set_button">
                <button type="submit" class="orange_button">更新</button>
                <a href="{{ route('detail',['id'=>$product -> id]) }}" class="blue_button space">戻る</a>
            </div>
        </div>

        </form>

    </div>
    </div>
</body>

</html>
