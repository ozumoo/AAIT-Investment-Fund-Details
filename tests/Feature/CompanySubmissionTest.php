<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanySubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker,DatabaseMigrations;

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class=CompanyListingsSeeder');
    }

    public function test_required_fields()
    {
        $response = $this->post('/company', []);
        $response->assertSessionHasErrors(['company_symbol', 'start_date', 'end_date', 'email']);
    }

    public function test_valid_email()
    {
        $response = $this->post('/company', [
            'email' => 'invalid-email',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_store_company_submission()
    {
        $data = [
            'company_symbol' => 'AAPL',
            'start_date' => '2023-08-09',
            'end_date' => '2023-09-30',
            'email' => 'ozumoo@gmail.com',
        ];

        $response = $this->post('/company', $data);
        $response->assertRedirect('/historical-quotes'); 

        $this->assertDatabaseHas('company_submissions', [
            'company_symbol' => 'AAPL',
            'start_date' => '2023-08-09',
            'end_date' => '2023-09-30',
            'email' => 'ozumoo@gmail.com',
        ]);
    }
}

