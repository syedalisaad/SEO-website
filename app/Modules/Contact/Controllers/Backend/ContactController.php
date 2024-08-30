<?php namespace App\Modules\Contact\Controllers\Backend;

use Illuminate\Http\Request;

use DataTables;

use App\Models\Contact;

class ContactController extends \App\Http\Controllers\AdminController
{
    public $module = 'Contact';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$CONTACT['LIST'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

       return view(
           admin_module_view('manage', $this->module)
       );
    }

    public function getAjaxList()
    {
        $data = Contact::all();

        return Datatables::of($data)
        ->addColumn('action', function($row){

            $action = '';

            if( isAdmin() || getAuth()->can(\Perms::$CONTACT['VIEW']) )
            {
                $action .= '<a href="javascript:void(0)" class="btn btn-success btn-sm const-show-more-details"
                    data-name="' . $row->name . '"
                    data-email="' . $row->email . '"
                    data-phone="' . ( $row->phone ?: '' ) . '"
                    data-subject="' . ( $row->subject ?: '' ) . '"
                    data-ipaddress="' . $row->ip_address . '"
                    data-message="' . $row->message . '"
                    data-created="' . $row->created_at . '"
                >
                    <i class="fas fa-eye"></i>
                </a> ';
            }

            if( isAdmin() || getAuth()->can(\Perms::$CONTACT['DELETE']) ) {
                $action .= '<a href="javascript:void(0)" data-href="'.route(admin_route('contact.delete'), [$row->id]).'" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
            }

            return $action?:'-';
        })
        ->addIndexColumn()
        ->editColumn('created_at', function($row) {
            return admin_datetime_format($row->created_at, true);
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$CONTACT['DELETE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $contact = Contact::findOrFail($id);
        $contact->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);

        return redirect()->route(admin_route('contact.index'));
    }
}
