<?php namespace App\Modules\Newsletter\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable implements ShouldQueue
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
        $template = ( 'vendor.mail.backend.newsletter.' . $this->template );
        $settings = get_site_settings();

        return $this->subject($this->subject)
        ->from($settings['sites']['email_no_reply'], $settings['sites']['site_name'])
        ->markdown($template);
    }
}
