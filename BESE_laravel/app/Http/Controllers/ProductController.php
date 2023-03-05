<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// model読み込み
use App\Models\Product;
// ポスト用
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    // 表示
    public function productMainView()
    {
        // query
        $products = new Product();
        $result = $products->getAll();
        return view('main_display', ['result' => $result]);
    }

    // public function productSalesView()
    // {
    //     $products = new Product();
    //     $result   = $products->getAll();
    //     return view('Product_information_edited_image', ['result' => $result]);
    // }



    // 入力フォーム

    // 表示
    public function productRegisterView()
    {
        $products = new Product();
        $result = $products->getAll();
        return view('Product_Register_display', ['result' => $result]);
    }

    // 新規作成

    public function productPost(Request $request)
    {
        // アップロードされたファイルの取得
        $image = $request->file('img_path');
        // ファイルの保存とパスの取得
        $path = $image->store('items', 'public');
        // データベースに登録
        \DB::table('products')->insert([
            'product_name' => $request->product_name,
            'company_id' => $request->makerName,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $path, //$request->img_path,
        ]);
        return redirect()->route('register');
    }

    /**
     * 削除処理
     */
    public function productDelete($id)
    {
        // テーブルから指定のIDのレコード1件を取得
        $result = Product::find($id);
        // 商品画像ファイルへのパスを取得
        $path = $result->img_path;

        // ファイルが登録されていれば削除
        if ($path !== '') {
            \Storage::disk('public')->delete($path);
        }
        // レコードを削除
        $result->delete();

        // 削除したら一覧画面にリダイレクト
        $products = new Product();
        $result = $products->getAll();
        return view('main_display', ['result' => $result]);
    }

    // 詳細画面表示
    public function productShow(Product $id)
    {
        return view('information_details', ['result' => $id]);
    }

    /**
     * 編集画面の表示
     */
    public function productEdit(Product $id)
    {
        return view('Product_edit', ['result' => $id]);
    }

    /**
     * 更新処理
     */
    public function productUpdate(Request $request, Product $id)
    {
        $result = Product::find($id);
        // 画像ファイルインスタンス取得
        $image = $request->file('img_path');
        // 現在の画像へのパスをセット
        $path = $id->img_path;
        if (isset($image)) {
            // 現在の画像ファイルの削除
            \Storage::disk('public')->delete($path);
        }
        // 選択された画像ファイルを保存してパスをセット
        $path = $image->store('items', 'public');


        // データベースを更新
        \DB::table('products')->update([
            'product_name' => $request->product_name,
            'company_id' => $request->makerName,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $path, //$request->img_path,
        ]);
        return redirect()->route('edit', $id);
    }













    // 検索画面

}
