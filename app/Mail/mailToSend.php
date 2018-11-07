<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailToSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $template;
    protected $name;

    public function __construct($template)
    {
        //
        $this->template = $template['file'];
        $this->name = $template['name'];
        $this->template = str_replace('former student', $this->name, $this->template);
        $this->template = str_replace(',', ',', $this->template);
        $this->template = str_replace('!', "!", $this->template);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.template')
                    ->subject('Nevermind English Town here\'s Teacher Tony!!!')
                    ->from('p.muangsaen@gmail.com');
    }
}
