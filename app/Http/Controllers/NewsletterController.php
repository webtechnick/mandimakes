<?php

namespace App\Http\Controllers;

use App\Traits\Flashes;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    use Flashes;

    public function subscribe($email = null)
    {
        $email = $email ?: request()->input('email');
        app('mailgun')->post('lists/'. config('services.mailgun.newsletter') .'/members', [
            'address' => $email,
            'subscribed' => 'yes',
            'upsert' => 'yes'
        ]);

        $this->goodFlash($email. ' added to the newsletter list.');
        return redirect('/');
    }

    public function unsubscribe($email = null)
    {
        $email = $email ?: request()->input('email');
        app('mailgun')->delete('lists/'. config('services.mailgun.newsletter') .'/members/' . $email);

        $this->goodFlash($email . ' unsubscribed.');
        return redirect('/');
    }
}
