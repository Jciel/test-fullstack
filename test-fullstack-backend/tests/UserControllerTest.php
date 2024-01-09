<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRequestToLoginWithValidData()
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Jhon',
            'email' => 'jhon@gmail.com',
            'password' => app('hash')->make(123456)
        ]);

        $data = [
            'email' => 'jhon@gmail.com',
            'password' => '123456',
        ];

        $this->post("/v1/login", $data);

        $this->assertResponseOk();
        $resArray = json_decode($this->response->getContent(), true);
        $this->assertEquals('Login success', $resArray['message']);
    }

    public function testRequestToLoginWithInesistentEmail()
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Jhon',
            'email' => 'jhon@gmail.com',
            'password' => app('hash')->make(123456)
        ]);

        $data = [
            'email' => 'jhonas@gmail.com',
            'password' => '123456',
        ];

        $this->post("/v1/login", $data);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $resArray = json_decode($this->response->getContent(), true);
        $this->assertEquals('User not found', $resArray['message']);
    }

    public function testRequestToLoginWithWrongPassword()
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Jhon',
            'email' => 'jhon@gmail.com',
            'password' => app('hash')->make(123456)
        ]);

        $data = [
            'email' => 'jhon@gmail.com',
            'password' => '123456789',
        ];

        $this->post("/v1/login", $data);

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $resArray = json_decode($this->response->getContent(), true);
        $this->assertEquals('Wrong password', $resArray['message']);
    }


    public function testRequestToRegisterAuser()
    {
        $data = [
            'name' => 'Jhon',
            'email' => 'jhon@gmail.com',
            'password' => '123456',
        ];

        $this->post("/v1/register", $data);

        $this->assertResponseOk();
        $resArray = json_decode($this->response->getContent(), true);
        $this->assertEquals('User created successfully', $resArray['message']);
        $this->seeInDatabase('users', ['name' => 'Jhon', 'email' => 'jhon@gmail.com']);
    }

    public function testRequestToRegisterWithNoEmail()
    {
        $data = [
            'name' => 'Jhon',
            'password' => '123456',
        ];

        $this->post("/v1/register", $data);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $resArray = json_decode($this->response->getContent(), true);
        $this->assertEquals('The email field is required., ', $resArray['message']);
        $this->notSeeInDatabase('users', ['name' => 'Jhon']);
    }

    public function testRequestToRegisterWithNoPassword()
    {
        $data = [
            'name' => 'Jhon',
            'email' => 'jhon@gmail.com'
        ];

        $this->post("/v1/register", $data);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->notSeeInDatabase('users', ['name' => 'Jhon', 'email' => 'jhon@gmail.com']);
    }
}
