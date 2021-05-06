<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class PasswordCheckTest extends TestCase
{
     use RefreshDatabase;
    /**
     * A Password check example.
     *
     * @return void
    */

    /** @test */
    public function a_user_can_register_account()
    {
        $response=$this->post(route('register'),[
            'name'=>'John Doe',
            'email'=>'john_doe@live.com',
            'password'=>'secretpas',
            'password_confirmation'=>'secretpas'
        ]);
        $response->assertRedirect('/home');
        $this->assertTrue(Auth::check());
        $this->assertCount(1,User::all());
        tap(User::first(),function($user){
            $this->assertEquals('John Doe',$user->name);
            $this->assertEquals('john_doe@live.com',$user->email);
            $this->assertTrue(Hash::check('secretpas', $user->password));
        });
    }

      /** @test */
    public function user_new_password_must_be_differnt_from_current_account()
    {
       $user = factory(User::class)->create([
        'password' => Hash::make('secretpas')
    ]);

        $request= $this->actingAs($user)->post("password/post_expired", [
        'current_password' => 'secretpas',
        'password' => 'mynewpassword',
        'password_confirmation' => 'mynewpassword'
    ]);

    $this->assertFalse(Hash::check('mynewpassword', $user->fresh()->password));

    }
}
