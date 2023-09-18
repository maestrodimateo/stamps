<?php
namespace Modules\Admin\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultPasswordSent extends Mailable
{
    use Queueable, SerializesModels;

    public string $password;
    public string $fullname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $password, string $fullname)
    {
        $this->password = $password;
        $this->fullname = $fullname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mot de passe par défaut')
        ->markdown('admin::emails.default-password-sent');
    }
}
