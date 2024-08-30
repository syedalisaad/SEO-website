<?php namespace App\Modules\Newsletter\Controllers\Backend;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Newsletter;
use \App\Modules\Newsletter\Mail\NewsletterMail;

class NewsletterController extends \App\Http\Controllers\AdminController
{
    public $module = 'Newsletter';

    /**
     * Send Newsletters by Candidates.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSendNewsletter(Request $request)
    {
        $validator = \Validator::make( $request->all(), [
            'newsletter_subject'   => 'required|max:30',
            'newsletter_message'   => 'required|max:250',
            'newsletter_candidate' => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $candidate = $request->newsletter_candidate;
        $emails    = [];

        switch ( $candidate )
        {
            case 'everyone':
                $emails = Newsletter::getEveryoneCandidates();
            break;
            case 'subscribers':
                $emails = Newsletter::getSubscriberCandidates();
            break;
            case 'contacts':
                $emails = Newsletter::getContactCandidates();
            break;
            case 'members':
                $emails = Newsletter::getMemberCandidates();
            break;
            case 'teams':
                $emails = Newsletter::getTeamCandidates();
            break;
        }

        //For Notifiy By "Email"
        if( count($emails) )
        {
            $subject  = $request->newsletter_subject;

            foreach ( $emails as $email )
            {
                $template = 'newsletter';
                $template = new NewsletterMail( $template, $subject, [
                    'subject' => $subject,
                    'message' => $request->newsletter_message
                ]);

                \Mail::to( $email )->send( $template );
            }
        }

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Newsletter successfully sent by "'.$candidate.'"'
        ]);
        return redirect()->route(admin_route('dashboard'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$NEWSLETTER['LIST'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

       return view(
           admin_module_view('manage', $this->module)
       );
    }

    public function getAjaxList()
    {
        $data = Newsletter::all();

        return Datatables::of($data)
        ->addColumn('action', function($row){

            $action = '';

            if( isAdmin() || getAuth()->can(\Perms::$NEWSLETTER['DELETE']) ) {
                $action .= '<a href="javascript:void(0)" data-href="'.route(admin_route('newsletter.delete'), [$row->id]).'" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
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
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$NEWSLETTER['DELETE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);
        return redirect()->route(admin_route('newsletter.index'));
    }
}
