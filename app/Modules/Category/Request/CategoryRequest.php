<?php namespace App\Modules\Category\Request;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $item_id = \Request::segment( 3 );

        $rules = [
            'name'         => 'required|max:255|unique:App\Models\Category,name,NULL,id,deleted_at,NULL',
            'parent_id'    => 'max:5',
            'short_desc'   => 'max:250',
            'source_image' => 'image|mimes:webp,jpeg,png,jpg,gif|max:' . env( 'IMG_MAX_SIZE', '2048' )
        ];

        switch ( $this->method() )
        {
            case 'PUT':
                $rules['name'] = 'required|max:255|unique:App\Models\Category,name,NULL,id,deleted_at,' . $item_id;
            break;
        }

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'source_image' => 'image'
        ];
    }
}
