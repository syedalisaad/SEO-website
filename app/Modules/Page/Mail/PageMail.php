<?php namespace App\Modules\Page\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PageMail extends Mailable
{
    use Queueable, SerializesModels;

    protected   $template = NULL;
    public      $subject  = NULL;
    public      $data     = NULL;
    public      $optional = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $template, $subject, $data, $optional = [] )
    {
        $this->template = $template;
        $this->subject  = $subject;
        $this->data     = $data;
        $this->optional = $optional;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = ( 'vendor.mail.frontend.page.' . $this->template );
        $settings = get_site_settings();
        $sites    = $settings['sites'];

        return $this->subject($this->subject)
        ->from($sites['email_no_reply'], $sites['site_name'])
        ->markdown($template);
    }
}
