<?php

use App\Models\User;
use Illuminate\Support\Str;

use function PHPUnit\Framework\assertEquals;

class RegisterTest extends TestCase
{
    private $endpoint = '/api/register';

    public function testWithEmptyRequest()
    {
        $response = $this->call('POST', $this->endpoint);

        $this->assertEquals(422, $response->status());
    }

    public function testWithProperDataInRequest()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username' => 'cynax',
            'email' => 'cynax@gmail.com',
            'password' => '123456',
        ]);

        $this->assertEquals(200, $response->status());
        User::where('username', 'cynax')->first()->delete();
    }

    public function testWithBadUsername()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username' => 'asd123#',
            'email' => 'asd@asd.com',
            'password' => '123456',
        ]);

        $this->assertEquals(422, $response->status());

        $response = $this->call('POST', $this->endpoint, [
            'username' => 'asd 123',
            'email' => 'asd@asd.com',
            'password' => '123456',
        ]);

        $this->assertEquals(422, $response->status());
    }

    public function testWithBadEmail()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username' => 'cynax',
            'email' => 'asd',
            'password' => '123456',
        ]);

        $this->assertEquals(422, $response->status());
    }

    public function testWithBadPassword()
    {
        $response = $this->call('POST', $this->endpoint, [
            'username' => 'cynax',
            'email' => 'asd@asd.com',
            'password' => 'a',
        ]);

        $this->assertEquals(422, $response->status());

        $response = $this->call('POST', $this->endpoint, [
            'username' => 'cynax',
            'email' => 'asd@asd.com',
            'password' => Str::random(126),
        ]);

        $this->assertEquals(422, $response->status());
    }

    public function testIfRegisteringSavesData()
    {
        /**
         * deletes the existing testuser before testing
         */
        $username = 'testuser';
        $user = User::where('username', $username)->first();
        if (!is_null($user)) {
            $user->delete();
        }
        /**
         * now the testuser doesnt exist anymore. good to go
         */

        $response = $this->call('POST', $this->endpoint, [
            'username' => $username,
            'email' => 'test@gmail.com',
            'password' => '123456',
        ]);
        $this->assertEquals(200, $response->status());

        $user = User::where('username', $username)->first();

        $this->assertNotNull($user);
        $user->delete();
    }

    public function testUniqueUsernameEmail()
    {
        $test_user = User::create([
            'username' => 'testuser',
            'email' => 'test@gmail.com',
            'password' => '123456',
        ]);

        $response = $this->call('POST', $this->endpoint, [
            'username' => 'testuser',
            'email' => 'test@gmail.com',
            'password' => 'asdasd',
        ]);

        assertEquals(422, $response->status());

        $test_user->delete();
    }
}
