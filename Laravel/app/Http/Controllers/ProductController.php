<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
// post用
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

    public function productInfoView()
    {
        $products = new Product();
        $result   = $products->getAll();
        return view('information_details', ['result' => $result]);
    }

    public function productSalesView()
    {
        $products = new Product();
        $result   = $products->getAll();
        return view('Product_information_edited_image', ['result' => $result]);
    }



    // 入力フォーム

    // 表示
    public function productRegisterView()
    {
        return view('Product_Register_display');
    }

    // POST


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
        return view('Product_Register_display');
    }

    /**
     * 削除処理
     */
    public function productDelete($id)
    {
        // テーブルから指定のIDのレコード1件を取得
        $result = Product::find($id);
        // レコードを削除
        $result->delete();

        // 削除したら一覧画面にリダイレクト
        $products = new Product();
        $result = $products->getAll();
        return view('main_display', ['result' => $result]);
    }

    // 詳細画面表示
    public function productShow($id)
    {
        $result = Product::find($id);
        return view('information_details', ['result' => $result]);
    }

    /**
     * 編集画面の表示
     */
    public function productEdit($id)
    {
        $result = Product::find($id);

        return view('Product_edit', ['result' => $result]);
    }

    /**
     * 更新処理
     */
    public function update(Request $request, $id)
    {
        $result = Product::find($id);
        $result->fill($request->input('result'));
        $result->save();
        return view('Product_edit', ['result' => $result]);
    }

    // 検索画面
    public function index(Request $request)
    {
        $keyword = $request->input('product');

        $query = Product::query();
        if (!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
        }

        $result = $query->get();

        return view('index', ['result' => $result]);
    }



    /**
     * 更新処理
     */
    // public function productUpdate(Request $request, $id)
    // {
    //     $result = Product::find($id);
    //     $result->update();

    //     return redirect()->route('book.index');
    // }

    /**
     * 画面表示件データ一件取得用
     */
    // public function productUpdate($id)
    // {
    //     $update = $this->update->selectUserFindById($id);
    //     return view('Product_edit', ['result' => $update]);
    // }
}
