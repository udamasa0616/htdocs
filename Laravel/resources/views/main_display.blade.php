<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset="utf-8">
    <title>ララベル自動販売機</title>
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('/css/appp.css') }}">
    <!-- js -->
    <script src="{{ asset('/js/jquery-3.1.1.min.js') }}"></script>

    <!-- img -->
</head>

<body>
    <header class="header">
        <h1>商品一覧画面</h1>
    </header>

    <main>
        @csrf
        <div>
            <form action="{{ route('posts.index') }}" method="GET">
                <input type="text" name="keyword" value="{{ $keyword }}">
                <input type="submit" value="検索">
            </form>
        </div>


        <div class="list-from">
            <label class="label-color" for="name">商品情報</label>
            <table>
                <thead>
                    <tr class="color-main">
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th>詳細表示</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $product)
                    <tr>
                        <th>{{ $product->products_id }}</th>
                        <th><img src="{{asset('storage/'.$product->img_path)}}" width="25%"></th>
                        <th>{{ $product->product_name }}</th>
                        <th>{{ $product->price }}</th>
                        <th>{{ $product->stock }}</th>
                        <th>{{ $product->company_id}}</th>
                        <th>{{ $product->comment }}</th>
                        <th><a href="{{ route('show', ['id'=>$product->products_id] )}}"><button>詳細情報</button></a></th>
                        <th>
                            <form onsubmit="return confirm('本当に削除しますか？')" action="{{ route('delete', ['id'=>$product->products_id]) }}" method="POST">
                            @csrf
                            <button type="submit">削除</button>
                            </form>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </main>

    <footer>
        <h2>自動販売機動作プログラム</h2>
    </footer>
    <script src="../js/resource.js" ></script>
</body>

</html>