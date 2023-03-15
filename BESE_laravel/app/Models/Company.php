<?php

namespace App\Models; //変更点

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{

    //Companyテーブルから::pluckでcompany_nameとidを抽出し、$categoriesに返す関数を作る
    public function getLists()
    {
        $categories = Company::pluck('company_name', 'id');

        return $categories;
    }
    //「カテゴリ(category)はたくさんの商品(products)をもつ」というリレーション関係を定義する
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
