<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        public function rules()
        {
            return [
                'product_name' => 'required |  max:255',
                'company_id' => 'required',
                'price'   => 'required | numeric | digits_between:2,3 |	alpha_num',
                'stock'   => 'required | numeric | digits_between:1,3 | alpha_num',
                'comment' => 'max:255',
                'img_path'    => 'required|image|mimes:jpeg,png,jpg,gif'
            ];
        }

        public function attributes()
        {
            return [
                'product_name' => '商品名',
                'company_id' => 'メーカー名',
                'price'   => '価格',
                'stock'   => '在庫数',
                'comment' => 'コメント',
                'img_path' => '画像'
            ];
        }

        /**
         * エラーメッセージ
         *
         * @return array
         */

        public function messages()
        {
            return [
                // 商品名 バリエーション
                'product_name.required'    => ':attributeは必須項目です',
                'product_name.max'         => ':attributeは:max字以内で入力してください。',

                // 価格     バリエーション
                'company_id.required'           => ':attributeは必須項目です',

                // 価格     バリエーション
                'price.required'           => ':attributeは必須項目です',
                'price.numeric'            => ':attributeに数値を入力してください',
                'price.digits_between:2,3' => ':attributeは999までの数値を入力してください',
                'price.alpha_num'          => ':attributeで入力してください',

                // 在庫数   バリエーション
                'stock.required'           => ':attributeは必須項目です',
                'stock.numeric'            => ':attributeに数値を入力してください',
                'stock.digits_between:2,3' => ':attributeに999より小さくしてください',
                'stock.alpha_num'          => ':attributeで入力してください',

                // コメント バリエーション
                'comment.required'         => ':attributeは必須項目です',
                'comment.alpha_num'        => ':attributeで入力してください',
                'comment.max'              => ':attributeは:max字以内で入力してください。',

                // 画像    バリエーション
                'img_path.required'        => ':attributeを選択してください',
                "img_path.image" => "指定されたファイルが画像ではありません。",
                "img_path.mines" => "指定された拡張子（PNG/JPG/GIF）ではありません。",
            ];
        }
    }