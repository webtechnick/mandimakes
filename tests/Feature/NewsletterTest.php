<?php

namespace Tests\Feature;

use App\Mail\Announcement;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Mailgun\Mailgun;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function admin_should_be_able_to_send_announcment()
    {
        Mail::fake();

        $this->signInAdmin();

        $response = $this->post('/admin/newsletters', [
            'subject' => 'Subject',
            'body' => 'Body'
        ]);

        Mail::assertSent(Announcement::class, function ($mail) {
            return $mail->subject == 'Subject' &&
                   $mail->content == 'Body' &&
                   $mail->hasTo(config('services.mailgun.newsletter'));
        });
    }

    /** @test */
    public function user_can_subscribe_to_newsletter()
    {
        $this->mailgun = $this->mock(Mailgun::class, 'mailgun');
        $this->mailgun->shouldReceive('post')
                       ->with(
                        'lists/newsletter@mandimakes.shop/members',
                        [
                            'address' => 'test@example.com',
                            'subscribed' => 'yes',
                            'upsert' => 'yes'
                        ]
                       )
                       ->once();

        $response = $this->get('/newsletters/subscribe/test@example.com');
    }

    /** @test */
    public function user_can_subscribe_to_newsletter_via_post()
    {
        $this->mailgun = $this->mock(Mailgun::class, 'mailgun');
        $this->mailgun->shouldReceive('post')
                       ->with(
                        'lists/newsletter@mandimakes.shop/members',
                        [
                            'address' => 'test@example.com',
                            'subscribed' => 'yes',
                            'upsert' => 'yes'
                        ]
                       )
                       ->once();

        $response = $this->post('/newsletters/subscribe', ['email' => 'test@example.com']);
    }

    /** @test */
    public function user_can_unsubscribe_from_newsletter()
    {
        $this->mailgun = $this->mock(Mailgun::class, 'mailgun');
        $this->mailgun->shouldReceive('delete')
                      ->with('lists/newsletter@mandimakes.shop/members/test@example.com')
                      ->once();

        $response = $this->get('/newsletters/unsubscribe/test@example.com');
    }

    /** @test */
    public function user_can_unsubscribe_from_newsletter_via_post()
    {
        $this->mailgun = $this->mock(Mailgun::class, 'mailgun');
        $this->mailgun->shouldReceive('delete')
                      ->with('lists/newsletter@mandimakes.shop/members/test@example.com')
                      ->once();

        $response = $this->post('/newsletters/unsubscribe', ['email' => 'test@example.com']);
    }
}
