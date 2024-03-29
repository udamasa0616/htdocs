<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset="utf-8">
    <title>ララベル自動販売機</title>
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('/css/appp.css') }}">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

</head>

<body>
    <header class="header">
        <h1>商品情報詳細画面</h1>
    </header>

    <main>

        @csrf
        <div class="list-from">
            <label class="label-color" for="name">商品情報</label>
            <thead>
                <table>
                    <tr class="color-main">

                        <th>商品情報ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>メーカー</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>コメント</th>
                    </tr>
            </thead>
            <tbody>
                @foreach ($result as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><img src="{{ asset('storage/' . $product->img_path) }}" width="25%"></td>
                        <td>{{ $product->product_name }}</td>
                        <td>
                            @if ($product->company_id === 1)
                                <p>コカコーラ</p>
                            @elseif($product->company_id === 2)
                                <p>サントリー</p>
                            @else
                                <p>チェリオ</p>
                            @endif
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{!! nl2br(e($product->comment)) !!}</td>
                    </tr>
            </tbody>
            </table>
        </div>

        <div>
            <button class="edit" type="button"><a href="{{ route('edit', $product) }}">編集</a></button>
            <button class="return-bottom" type="button"><a href="{{ route('main') }}">戻る</a></button>
        </div>
        @endforeach

    </main>


    <footer>
        <h2>自動販売機動作プログラム</h2>
    </footer>
</body>

</html>
