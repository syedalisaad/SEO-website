<?php namespace App\Modules\Page\Request;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'name'                  => 'required|max:200|unique:pages',
            'description'           => 'max:20000',
            //'source_image'          => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        switch ( $this->method() )
        {
            case 'PUT':
                $rules['name'] = 'required|min:5|max:200|unique:pages,id,' . $item_id;
                //$rules['source_image'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
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
            'source_image'   => 'Image',
        ];
    }
}
