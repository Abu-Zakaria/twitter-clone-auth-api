<?php

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

        $response = $this->call('POST', $this->endpoinst, [
            'username' => 'cynax',
            'email' => 'asd@asd.com',
            'password' => Str::random(126),
        ]);

        $this->assertEquals(422, $response->status());
    }
}
