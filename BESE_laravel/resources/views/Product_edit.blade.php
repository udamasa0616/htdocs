<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset="utf-8">
    <title>ララベル自動販売機</title>
    <!-- css -->

    <link rel="stylesheet" href="{{ asset('/css/appp.css') }}">
    <!-- js -->
    <script src="{{ asset('/js/jquery-3.1.1.min.js') }}"></script>

</head>

<body>
    <header class="header">
        <h1>商品情報編集画面</h1>
    </header>

    <main>
        @csrf

        <div class="list-from">
            <!-- <button class="edit" type="button">更新</button> -->
            <label class="label-color" for="name">商品情報</label>
            <table>
                <thead>
                    <tr class="color-main">
                        <th>ID</th>
                        <th>商品名</th>
                        <th>メーカー名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>コメント</th>
                        <th>商品画像</th>

                    </tr>
                </thead>
                @foreach ($result as $product)
                    <form method="post" action="{{ route('product_update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        <tbody>

                            <tr>

                                <th>{{ $product->id }}</th>

                                <th>
                                    <input value="{{ old('product_name', $product->product_name) }}" type="text"
                                        id="product_name" name="product_name" required minlength="1" maxlength="8"
                                        size="10">
                                </th>
                                @if ($errors->has('product_name'))
                                    <p>{{ $errors->first('product_name') }}</p>
                                @endif
                                <th>
                                    <select id='makerName' name="makerName">
                                        <option>選択してください</option>
                                        <option value="1" @if (old('makerName') === $product->makerName) selected @endif>
                                            EAST
                                        </option>
                                        <option value="2" @if (old('makerName') === $product->makerName) selected @endif>
                                            WEST
                                        </option>
                                        <option value="3" @if (old('makerName') === $product->makerName) selected @endif>
                                            Group
                                        </option>
                                    </select>

                                <th>
                                    <input value="{{ old('price', $product->price) }}" type="text" id="price"
                                        name="price" required minlength="1" maxlength="8" size="10">
                                    @if ($errors->has('price'))
                                        <p>{{ $errors->first('price') }}</p>
                                    @endif
                                </th>

                                <th>
                                    <input value="{{ old('stock', $product->stock) }}" type="text" id="stock"
                                        name="stock" required minlength="1" maxlength="8" size="10">
                                    @if ($errors->has('stock'))
                                        <p>{{ $errors->first('stock') }}</p>
                                    @endif
                                </th>

                                <th>
                                    <textarea name="comment" id="comment">{{ old('comment', $product->comment) }}</textarea>
                                    @if ($errors->has('comment'))
                                        <p>{{ $errors->first('comment') }}</p>
                                    @endif
                                </th>

                                <th>
                                    <img src="{{ asset('storage/' . $product->img_path) }}" width="25%">
                                    <input name='img_path' class="img_path" type="file" required>
                                    @if ($errors->has('img_path'))
                                        <p>{{ $errors->first('img_path') }}</p>
                                    @endif
                                </th>
                            </tr>
                        </tbody>

            </table>

            <input type="submit" class="makerName-search" id="" value="更新">

            </form>


        </div>

        <button class="return-button" type="button"><a
                href="{{ route('show', ['id' => $product->id]) }}">戻る</a></button>
        </div>
        @endforeach
    </main>

    <footer>
        <h2>自動販売機動作プログラム</h2>
    </footer>
</body>

</html>
