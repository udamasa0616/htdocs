<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    // テーブルからデータを取得
    public function getAll()
    {
        $sales = DB::table($this->sales)
            // ->(クエリビルダ)
            ->select(
                'user_name',
                'email',
                'password',
            )

            ->get();
        return $sales;
    }
}
