<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// model読み込み
use App\Models\Product;
use App\Models\Company;
// ポスト用
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class ProductController extends Controller
{
    protected $fillable = ['product_name', 'company_id', 'price', 'stock', 'comment',  'img_path'];


    // 画面一覧

    // 表示
    public function productMainView(Request $request)
    {
        // query
        //フォームを機能させるために各情報を取得し、viewに返す

        $category = new Company;
        $categories = $category->getLists();
        $searchWord = $request->input('searchWord');
        $categoryId = $request->input('categoryId');

        $products = new Product;
        $result = $products->getAll();
        return view('main_display', [
            'result' => $result,
            'categories' => $categories,
            'searchWord' => $searchWord,
            'categoryId' => $categoryId
        ]);
    }

    /*==================================
    検索メソッド(search_product)
    ==================================*/
    public function search(Request $request) //$req
    {
        //入力される値nameの中身を定義する
        $searchWord = $request->searchWord; //商品名の値
        $categoryId = $request->categoryId; //カテゴリの値

        $query = Product::query();
        //商品名が入力された場合、productsテーブルから一致する商品を$queryに代入
        if (isset($searchWord)) {
            $query->where('product_name', 'like', '%' . self::escapeLike($searchWord) . '%');
        }
        //カテゴリが選択された場合、companyテーブルからidが一致する商品を$queryに代入
        if (isset($categoryId)) {
            $query->where('company_id', $categoryId);
        }

        //$queryをidの昇順に並び替えて$productsに代入
        $products = $query->orderBy('id', 'asc')->paginate(15);

        //companyテーブルからgetLists();関数でcategory_nameとidを取得する
        $category = new Company;
        $categories = $category->getLists();


        $product = new Product;
        $result = $product->getAll();
        return view('main_display', [
            'products' => $products,
            'categories' => $categories,
            'searchWord' => $searchWord,
            'categoryId' => $categoryId,
            'result' => $result,
        ]);
    }

    //「\\」「%」「_」などの記号を文字としてエスケープさせる
    public static function escapeLike($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }





    // 表示 入力フォーム
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

        $category = new Company;
        $categories = $category->getLists();
        $searchWord = "";
        $categoryId =  "";

        return view('main_display', [
            'categories' => $categories,
            'searchWord' => $searchWord,
            'categoryId' => $categoryId,
            'result' => $result,
        ]);
    }

    // 詳細画面表示
    public function productShow(Product $id)
    {
        $result = Product::find($id);

        return view('information_details', ['result' => $result]);
    }

    /**
     * 編集画面の表示
     */
    public function productEdit(Product $id)
    {
        $result = Product::find($id);
        return view('Product_edit', ['result' => $result]);
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
        \DB::table('products')
            ->where('id', $id->id)
            ->update([
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
    /*==================================
    検索フォームのみ表示(show)
    ==================================*/
    // public function search_show(Request $request)
    // {
    //     //フォームを機能させるために各情報を取得し、viewに返す
    //     $category = new Product;
    //     $categories = $category->getLists();
    //     $searchWord = $request->input('searchWord');
    //     $categoryId = $request->input('categoryId');

    //     return view('main_display', [
    //         'categories' => $categories,
    //         'searchWord' => $searchWord,
    //         'categoryId' => $categoryId
    //     ]);
    // }

    // /*==================================
    // 検索メソッド(searchproduct)
    // ==================================*/
    // public function search(Request $request)
    // {
    //     //入力される値nameの中身を定義する
    //     $searchWord = $request->input('searchWord'); //商品名の値
    //     $categoryId = $request->input('categoryId'); //カテゴリの値

    //     $query = MProduct::query();
    //     //商品名が入力された場合、m_productsテーブルから一致する商品を$queryに代入
    //     if (isset($searchWord)) {
    //         $query->where('product_name', 'like', '%' . self::escapeLike($searchWord) . '%');
    //     }
    //     //カテゴリが選択された場合、m_categoriesテーブルからcategory_idが一致する商品を$queryに代入
    //     if (isset($categoryId)) {
    //         $query->where('category_id', $categoryId);
    //     }

    //     //$queryをcategory_idの昇順に並び替えて$productsに代入
    //     $products = $query->orderBy('category_id', 'asc')->paginate(15);

    //     //m_categoriesテーブルからgetLists();関数でcategory_nameとidを取得する
    //     $category = new MCategory;
    //     $categories = $category->getLists();

    //     return view('searchproduct', [
    //         'products' => $products,
    //         'categories' => $categories,
    //         'searchWord' => $searchWord,
    //         'categoryId' => $categoryId
    //     ]);
    // }

    // //「\\」「%」「_」などの記号を文字としてエスケープさせる
    // public static function escapeLike($str)
    // {
    //     return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    // }
}
