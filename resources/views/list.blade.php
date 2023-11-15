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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--ajaxのリクエスト時に利用するCSRFトークン-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="antialiased">
    <div class="container">
        <div class="title">
            <h1>商品一覧画面</h1>
        </div>

        <!--検索機能はここから-->
        <div class="search">
            <form>
                <div class="text_search">
                    <input type="text" name="keyword" placeholder="検索キーワード" class="search_box">
                    <select name="company" id="company" class="search_box">
                        <option value="" selected>メーカー名</option>
                        @foreach ($companies as $company)
                        <option value="{{$company->company_name}}">{{$company->company_name}}</option>
                        @endforeach
                    </select>
                </div>
                <!--価格上限検索ここから-->
                <div class="price_search">
                    <input type="number" name="search_min_price" placeholder="下限価格" class="search_box string_box"> 
                    <p>{{__('~')}}</p>
                    <input type="number" name="search_max_price" placeholder="上限価格" class="search_box string_box">
                </div>
                <!--価格上限検索ここまで-->
                <button type="button" class="search_box" id="search_button">検索</button>
            </form>
        </div>
        <!--検索機能はここまで-->

        <div class="list">
            <table>
                <thead>
                    <tr>
                        <th class="product_id">@sortablelink('id', 'ID')</th>
                        <th class="product">商品画像</th>
                        <th class="product">@sortablelink('product_name', '商品名')</th>
                        <th class="product">@sortablelink('price', '価格')</th>
                        <th class="product">@sortablelink('stock', '在庫数')</th>
                        <th class="product">@sortablelink('company.company_name', 'メーカー名')</th>
                        <th class="product_button" colspan="2"><a href="add" class="add_button">新規登録</a></th>
                    </tr>
                </thead>
                <tbody id="list_table">
                    @foreach ($products as $product)
                    <tr>
                        <td class="product_id">{{ $product->id }}.</td>
                        <td class="product"><img src="{{asset('storage/'.$product->img_path) }}"></td>
                        <td class="product">{{ $product->product_name }}</td>
                        <td class="product">￥{{ $product->price }}</td>
                        <td class="product">{{ $product->stock }}</td>
                        <td class="product">{{ $product->company->company_name }}</td>
                        <td class="product_button">
                            <form action="{{ route('detail') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <button type="submit" class="blue_button space">詳細</button>
                            </form>
                        </td>
                        <td class="product_button">
                            <form>
                                @csrf
                                <button type="button" class="red_button delete_button" name="productid" value="{{$product->id}}">削除</button>
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
    <!--非同期処理-->
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $('#search_button').on('click', function(){
            $('#list_table').empty(); //もともとある要素を空にする
            let keyword = $('input[name="keyword"]').val();
            let company = $('select[name="company"]').val();
            let min_price = $('input[name="search_min_price"]').val();
            let max_price = $('input[name="search_max_price"]').val();

            $.ajax({
                url: "{{ route('search') }}",
                method: "POST",
                data: { 'keyword' : keyword, 'company' : company, 'min_price' : min_price, 'max_price' : max_price },
                dataType: "json",
            }).done(function(res){
                for(let i = 0 ; i < res.products.data.length ; i++){
                    let product = res.products.data[i];
                    html = `
                        <tr>
                            <td class="product_id">${product.id}.</td>
                            <td class="product"><img src="http://localhost:8888/VendingMachineSalesManagementSystem/public/storage/${product.img_path}"></td>
                            <td class="product">${product.product_name}</td>
                            <td class="product">￥${product.price}</td>
                            <td class="product">${product.stock}</td>
                            <td class="product">${res.companies[i]}</td>
                            <td class="product_button">
                                <form action="{{ route('detail') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="${product.id}">
                                <button type="submit" class="blue_button space">詳細</button>
                            </form>
                            </td>
                            <td class="product_button">
                                <form action="{{ route('delete' ,  ['id'=>$product->id ]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="red_button">削除</button>
                                </form>
                            </td>
                        </tr>
                            `
                    $('#list_table').append(html);
                }
                
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });

        $('.delete_button').on('click', function(){
            let clickEle = $(this);//クリックしたボタンの要素を取得
            let id = clickEle.attr('value');//クリックしたボタンのvalueを取得＝id
            $.ajax({
                url: "{{ route('delete') }}",
                method: "POST",
                data: { 'id' : id },
            }).done(function(res){
                clickEle.parents('tr').remove();
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });
    </script>

</body>

</html>
