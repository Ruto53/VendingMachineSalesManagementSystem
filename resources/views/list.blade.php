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
            <h1>商品一覧画面</h1>
        </div>

        <!--検索機能はここから-->
        <div class="search">
            <form action="{{  route('list')  }}" method="POST">
                @csrf
                <input type="text" name="keyword" placeholder="検索キーワード" class="search_box">
                <select name="company" id="company" class="search_box">
                    <option value="" selected>メーカー名</option>
                    @foreach ($companies as $company)
                    <option value="{{$company->company_name}}">{{$company->company_name}}</option>
                    @endforeach
                </select>
                <button type="submit" class="search_box">検索</button>
            </form>
        </div>
        <!--検索機能はここまで-->
        <div class="list">
            <table>
                <thead>
                    <tr>
                        <th class="product_id">ID</th>
                        <th class="product">商品画像</th>
                        <th class="product">商品名</th>
                        <th class="product">価格</th>
                        <th class="product">在庫数</th>
                        <th class="product">メーカー名</th>
                        <th class="product_button" colspan="2"><a href="add" class="add_button">新規登録</a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td class="product_id">{{ $product->id }}.</td>
                        <td class="product"><img src="{{asset('storage/'.$product->img_path) }}"></td>
                        <td class="product">{{ $product->product_name }}</td>
                        <td class="product">￥{{ $product->price }}</td>
                        <td class="product">{{ $product->stock }}</td>
                        <td class="product">{{ $product->company->company_name }}</td>
                        <td class="product_button">
                            <form action="{{ route('detail' , ['id'=>$product->id ]) }}" method="post">
                                @csrf
                                <button type="submit" class="blue_button space">詳細</button>
                            </form>
                        </td>
                        <td class="product_button">
                            <form action="{{ route('delete' , ['id'=>$product->id ]) }}" method="POST">
                                @csrf
                                <button type="submit" class="red_button">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="pajinate">
            {{ $products->links() }}
        </div>
    </div>

</body>

</html>
