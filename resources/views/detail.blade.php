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
            <h1>商品情報詳細画面</h1>
        </div>
        <div class="detail_container">
            <table>
                <tbody>
                    <tr>
                        <th class="add_title">ID</th>
                        <th class="detail_box">{{ $product -> id }}.</th>
                    </tr>
                    <tr>
                        <th class="add_title">商品画像</th>
                        <th class="detail_img"><img src="{{asset('storage/'.$product->img_path) }}"></th>
                    </tr>
                    <tr>
                        <th class="add_title">商品名</th>
                        <th class="detail_box">{{ $product -> product_name }}</th>
                    </tr>
                    <tr>
                        <th class="add_title">メーカー</th>
                        <th class="detail_box">{{ $product->company->company_name }}</th>
                    </tr>
                    <tr>
                        <th class="add_title">価格</th>
                        <th class="detail_box">￥{{ $product -> price }}</th>
                    </tr>
                    <tr>
                        <th class="add_title">在庫数</th>
                        <th class="detail_box">{{ $product -> stock }}</th>
                    </tr>
                    <tr>
                        <th class="add_title">コメント</th>
                        <th class="detail_box">{{ $product -> comment }}</th>
                    </tr>

                </tbody>
            </table>
            <div class="set_button">
                <form action="{{ route('edit' , ['id'=>$product->id ]) }}" method="get">
                    @csrf
                    <button type="submit" class="orange_button">編集</button>
                    <a href="list" class="blue_button space">戻る</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
