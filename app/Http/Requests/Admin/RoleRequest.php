<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|max:255|unique:\Spatie\Permission\Models\Role,name'
        ];

        switch ( $this->method() )
        {
            case 'PUT':
                $rules['name'] = 'required|max:255|unique:\Spatie\Permission\Models\Role,name,' . $item_id;
            break;
        }

        return $rules;
    }
}
