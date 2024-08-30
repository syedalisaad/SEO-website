<?php namespace App\Modules\Blog\Request;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'name'         => 'required|min:5|max:200|unique:posts,name,NULL,id,deleted_at,NULL',
            'short_desc'   => 'required|max:250',
            'description'  => 'required',
            'source_image' => 'required|image|mimes:webp,jpeg,png,jpg,gif|max:' . env( 'IMG_MAX_SIZE', '2048' ),
        ];

        switch ( $this->method() )
        {
            case 'PUT':
                $rules['name'] = 'required|max:200|unique:posts,name,' . $item_id;
                $rules['source_image'] = 'image|mimes:webp,jpeg,png,jpg,gif|max:'. env( 'IMG_MAX_SIZE', '2048' );
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
            'short_desc'   => 'short description',
            'source_image' => 'post image',
        ];
    }
}
