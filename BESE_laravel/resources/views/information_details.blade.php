<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset="utf-8">
    <title>ララベル自動販売機</title>
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('/css/appp.css') }}">
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

                <tr>
                    <td>{{ $result->id }}</td>
                    <td><img src="{{ asset('storage/' . $result->img_path) }}" width="25%"></td>
                    <td>{{ $result->product_name }}</td>
                    <td>
                        @if ($result->company_id === 1)
                            <p>WEST</p>
                        @elseif($result->company_id === 2)
                            <p>EAST</p>
                        @else
                            <p>Group</p>
                        @endif
                    </td>
                    <td>{{ $result->price }}</td>
                    <td>{{ $result->stock }}</td>
                    <td>{!! nl2br(e($result->comment)) !!}</td>
                </tr>
            </tbody>
            </table>
        </div>

        <div>
            <button class="edit" type="button"><a href="{{ route('edit', $result) }}">編集</a></button>
            <button class="return-bottom" type="button"><a href="{{ route('main') }}">戻る</a></button>
        </div>



    </main>


    <footer>
        <h2>自動販売機動作プログラム</h2>
    </footer>
</body>

</html>
