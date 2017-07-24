<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Announcement;
use App\Traits\Flashes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminNewsletterController extends Controller
{
    use Flashes;

    /**
     * Form for the announcment.
     * @return [type] [description]
     */
    public function create()
    {
        return view('admin.newsletters.create');
    }

    /**
     * Send the newsletter
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function send(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'body' => 'required'
        ]);

        Mail::to(config('services.mailgun.newsletter'))
              ->send(new Announcement($request->input('body'), $request->input('subject')));

        $this->goodFlash('Newsletter Sent');

        return redirect()->route('admin.newsletters.create');
    }
}
