<?php namespace App\Modules\User\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $user_id = \Request::segment( 3 );

        $rules = [
            'first_name'    => 'required|max:15',
            'last_name'     => 'required|max:15',
            'email'         => 'required|email|max:50|unique:App\Models\User,email,NULL,id,deleted_at,NULL',
            'phone'         => 'required|max:20',
            //'age'           => 'required|numeric|min:18|max:80',
            'country'       => 'nullable|exists:App\Models\Country,id',
            'state'         => 'nullable|exists:App\Models\State,id',
            'city'          => 'nullable|exists:App\Models\City,id',
            'address'       => 'max:250',
            'zipcode'       => 'max:10',
            'source_image'  => 'image|mimes:webp,jpeg,png,jpg,gif|max:2048',

            //Redirect
            'formsubmit'    => 'required|in:user.create,user.index',
        ];

        $rules['hospital_id'] = ['required',
            Rule::unique( 'user_details' )->where( function( $query ) use ( $user_id ) {
                return $query->where( 'hospital_id', $this->input( 'hospital_id' ) )->where('is_hospital_approved', 1)->where( 'user_id', '<>', $user_id );
            }),
        ];

        switch ( $this->method() )
        {
            case 'PUT':

                $rules['email'] = ['required', 'max:50',
                    Rule::unique( 'users' )->where( function( $query ) use ( $user_id ) {
                        return $query->whereEmail( $this->input( 'email' ) )->where( 'id', '<>', $user_id )->whereNull('deleted_at');
                    }),
                ];

                if ( $this->password ) {
                    $rules['password'] = 'min:8|max:20';
                }

            break;
            default:

                //$rules['hospital_id']   = 'required|exists:App\Models\Hospital,id|unique:App\Models\UserDetail,hospital_id';
                $rules['password']      = 'required|min:8|max:20';
                $rules['source_image']  = 'image|mimes:webp,jpeg,png,jpg,gif|max:2048';
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
            'hospital_id' => 'hospital',
            'source_image' => 'profile image',
            'formsubmit'   => 'submit button',
        ];
    }
}
