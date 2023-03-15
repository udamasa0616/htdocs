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
        <div class="mx-auto">
            <br>
            <h2 class="text-center">商品検索画面</h2>
            <br>
            <!--検索フォーム-->
            <div class="row">
                <div class="col-sm">
                    <form method="GET" action="{{ route('search_product') }}">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">商品名</label>
                            <!--入力-->
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="searchWord"
                                    value="{{ $searchWord }}">
                            </div>
                            <div class="col-sm-auto">
                                <button type="submit" class="btn btn-primary ">検索</button>
                            </div>
                        </div>
                        <!--プルダウンカテゴリ選択-->
                        <div class="form-group row">
                            <label class="col-sm-2">メーカ名</label>
                            <div class="col-sm-3">
                                <select name="categoryId" value="{{ $categoryId }}">
                                    <option value="">未選択</option>

                                    @foreach ($categories as $id => $category_name)
                                        <option value="{{ $id }}">
                                            {{ $category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--検索結果テーブル 検索された時のみ表示する-->
        @if (!empty($products))
            <div class="productTable">
                <p>全{{ $products->count() }}件</p>
                <table class="table table-hover">
                    <thead style="background-color: #ffd900">
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
                    @foreach ($products as $product)
                        <tbody>

                            <tr>
                                <th>{{ $product->id }}</th>
                                <th><img src="{{ asset('storage/' . $product->img_path) }}" width="25%"></th>
                                <th>{{ $product->product_name }}</th>
                                <th>{{ $product->price }}円</th>
                                <th>{{ $product->stock }}個</th>
                                <th>
                                    @if ($product->company_id === 1)
                                        <p>WEST</p>
                                    @elseif($product->company_id === 2)
                                        <p>EAST</p>
                                    @else
                                        <p>Group</p>
                                    @endif
                                </th>
                                <td>{{ $product->comment }}</td>
                                <td><a href="{{ route('show', ['id' => $product->id]) }}"><button>詳細情報</button></a>
                                </td>
                                <td>
                                    <form onsubmit="return confirm('本当に削除しますか？')"
                                        action="{{ route('delete', ['id' => $product->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit">削除</button>
                                    </form>
                                </td>
                            </tr>
                    @endforeach
                </table>
            </div>
            <!--テーブルここまで-->

            <!--ページネーション-->
            <div class="d-flex justify-content-center">
                {{-- appendsでカテゴリを選択したまま遷移 --}}
                {{ $products->appends(request()->input())->links() }}
            </div>
            <!--ページネーションここまで-->
        @endif





        {{-- 登録画面移行 --}}
        <button class="new-register" type="button">
            <a href="{{ route('register') }}">新規</a>
        </button>

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
                            <th><img src="{{ asset('storage/' . $product->img_path) }}" width="25%"></th>
                            <th>{{ $product->product_name }}</th>
                            <th>{{ $product->price }}円</th>
                            <th>{{ $product->stock }}個</th>
                            <th>
                                @if ($product->company_id === 1)
                                    <p>WEST</p>
                                @elseif($product->company_id === 2)
                                    <p>EAST</p>
                                @else
                                    <p>Group</p>
                                @endif
                            </th>
                            <th>{{ $product->comment }}</th>
                            <th><a
                                    href="{{ route('show', ['id' => $product->products_id]) }}"><button>詳細情報</button></a>
                            </th>
                            <th>
                                <form onsubmit="return confirm('本当に削除しますか？')"
                                    action="{{ route('delete', ['id' => $product->products_id]) }}" method="POST">
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
    <script src="../js/resource.js"></script>
</body>

</html>
