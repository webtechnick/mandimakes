<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCanUpdateProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_update_their_profile()
    {
        $user = $this->signIn();

        $data = [
            'name' => 'New Name',
            'email' => $user->email,
        ];

        $response = $this->patch('/account', $data);

        $this->assertEquals($user->fresh()->name, $data['name']);
    }

    /** @test */
    public function user_cannot_take_an_already_taken_email()
    {
        $user = $this->signIn();
        $anotherUser = $this->create('App\User', ['email' => 'test@example.com']);

        $data = [
            'name' => 'New Name',
            'email' => $anotherUser->email,
        ];

        $response = $this->patch('/account', $data);
        $response->assertSessionHasErrors('email');

        $this->assertNotEquals($user->fresh()->name, $data['name']);
        $this->assertNotEquals($user->fresh()->email, $data['email']); // Not changed.
    }

    /** @test */
    public function user_can_update_their_password()
    {
        $user = $this->signIn($this->create('App\User', [
            'password' => Hash::make('old_pass')
        ]));

        $data = [
            'password' => 'old_pass',
            'new_password' => 'new_pass',
            'new_password_confirmation' => 'new_pass'
        ];

        $response = $this->patch('/account/password', $data);
        $this->assertTrue(Hash::check($data['new_password'], $user->fresh()->password));
    }

    /** @test */
    public function user_cannot_update_password_if_incorrect()
    {
        $user = $this->signIn($this->create('App\User', [
            'password' => Hash::make('old_pass')
        ]));

        $data = [
            'password' => 'wrong_pass',
            'new_password' => 'new_pass',
            'new_password_confirmation' => 'new_pass'
        ];

        $response = $this->patch('/account/password', $data);
        $response->assertSessionHasErrors('password');
        $this->assertFalse(Hash::check($data['new_password'], $user->fresh()->password));
    }

    /** @test */
    public function user_cannot_update_password_if_not_confirmed()
    {
        $user = $this->signIn($this->create('App\User', [
            'password' => Hash::make('old_pass')
        ]));

        $data = [
            'password' => 'old_pass',
            'new_password' => 'new_pass',
            'new_password_confirmation' => 'wrong_pass'
        ];

        $response = $this->patch('/account/password', $data);
        $response->assertSessionHasErrors('new_password');
        $this->assertFalse(Hash::check($data['new_password'], $user->fresh()->password));
    }
}
