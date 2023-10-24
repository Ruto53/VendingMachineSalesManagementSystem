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

<body class="antialiased">
    <div class="container">
        <div class="title">
            <h1>商品新規登録画面</h1>
        </div>
        <div>
            <div class="add_list">
                <table>
                    <tbody>
                        <form action=" {{ route('submit') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <tr>
                                <td class="add_title"><label for="product_name">商品名<span
                                            class="required">*</span></label></td>
                                <td><input type="text" name="product_name" id="product_name" placeholder="コーラ"
                                        value="{{ old('product_name') }}" class="add_box">
                                    @if ($errors -> has('product_name'))
                                    <p class="error">{{ $errors->first('product_name') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="add_title"><label for="company_id">メーカー名<span
                                            class="required">*</span></label></td>
                                <td><select name="company_id" id="company_id" class="add_box">
                                        <option value="null" hidden>選択してください</option>
                                        @foreach ($companies as $company)
                                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors -> has('company_id'))
                                    <p class="error">{{ $errors->first('company_id') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="add_title"><label for="price">価格<span class="required">*</span></label></td>
                                <td><input type="number" name="price" id="price" placeholder="100" step="1"
                                        value="{{ old('price') }}" class="add_box">
                                    @if ($errors -> has('price'))
                                    <p class="error">{{ $errors->first('price') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="add_title"><label for="stock">在庫数<span class="required">*</span></label></td>
                                <td><input type="number" name="stock" id="stock" placeholder="10"
                                        value="{{ old('stock') }}" class="add_box">
                                    @if ($errors -> has('stock'))
                                    <p class="error">{{ $errors->first('stock') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="add_title"><label for="comment">コメント</label></td>
                                <td><textarea name="comment" id="comment" cols="30" rows="2"
                                        class="add_box">{{ old('comment') }}</textarea>
                                    @if ($errors -> has('comment'))
                                    <p class="error">{{ $errors->first('comment') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="add_title"><label for="img_path">商品画像</label></td>
                                <td><input type="file" name="img_path" id="img_path" class="add_img"></td>
                            </tr>
                    </tbody>
                </table>
                <div class="set_button">
                    <button type="submit" class="orange_button">新規登録</button>
                    <a href="list" class="blue_button space">戻る</a>
                </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
