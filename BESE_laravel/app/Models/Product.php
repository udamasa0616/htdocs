<?php

namespace App\Models; //変更点

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    // テーブルからデータを取得
    public function getAll()
    {
        $products = DB::table('Products') //DB名
            // ->(クエリビルダ)
            ->select(
                'products.id as products_id',
                'company_id',
                'product_name',
                'price',
                'stock',
                'comment',
                'img_path',
                'company_name'
            )
            ->leftJoin(
                'companies',
                'companies.id',
                '=',
                'products.company_id'
            )
            ->get();

        return $products;
    }

    // Post

    public function registerArticle($request)
    {

        DB::table('Products')->insert([
            'products.id as products_id' => $request->products_id,
            'product_name' => $request->product_name,
            'company_id'   => $request->makerName,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'comment'      => $request->comment,
            'img_path'     => $request->img_path
        ]);
    }

    public function productDelete($id)
    {
        DB::table('Products')->delete([
            'products.id as products_id' => $id->products_id,
            'product_name' => $id->product_name,
            'company_id'   => $id->makerName,
            'price'        => $id->price,
            'stock'        => $id->stock,
            'comment'      => $id->comment,
            'img_path'     => $id->img_path
        ]);
    }

    public function productUpdate($request, $id)
    {
        DB::table('Products')
            ->update([
                'products.id as products_id' => $$request->products_id,
                'product_name' => $request->product_name,
                'company_id'   => $request->makerName,
                'price'        => $request->price,
                'stock'        => $request->stock,
                'comment'      => $request->comment,
                'img_path'     => $request->img_path
            ]);
    }

    // 検索 インプット
    //m_categoriesテーブルから::pluckでcategory_nameとidを抽出し、$categoriesに返す関数を作る
    public function getLists()
    {
        $categories = Product::pluck('product_name', 'id');

        return $categories;
    }
    // //「カテゴリ(category)はたくさんの商品(products)をもつ」というリレーション関係を定義する
    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }

    // // セレクトボックス

    // //「商品(products)はカテゴリ(category)に属する」というリレーション関係を定義する
    // public function category()
    // {
    //     return $this->belongsTo(product::class);
    // }
}
