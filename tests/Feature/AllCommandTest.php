<?php

namespace Tests\Unit\Commands\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class AllCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_a_path_argument()
    {
        $this->artisan('app:all')
             ->expectsOutput('Not enough arguments (missing: "path").')
             ->assertExitCode(1);
    }

    /** @test */
    public function it_throws_an_error_if_the_file_does_not_exist()
    {
        $this->artisan('app:all', ['path' => '/path/to/nonexistent/file.xml'])
             ->expectsOutput('An error occurred while processing the XML file: Unable to open file.')
             ->assertExitCode(1);
    }

    /** @test */
    public function it_processes_a_valid_xml_file_and_stores_the_data()
    {
        Storage::fake('local');
        Storage::disk('local')->put('test.xml', '...'); // Put your test XML content here

        $this->artisan('app:all', ['path' => storage_path('app/test.xml')])
             ->expectsOutput('Successfully processed the XML file and stored the data.')
             ->assertExitCode(0);

        // Here, you would also want to assert that the data was correctly stored in the database.
    }

    /** @test */
    public function it_throws_an_error_if_the_xml_file_is_malformed()
    {
        Storage::fake('local');
        Storage::disk('local')->put('test.xml', '<item><entity_id>123'); // Incomplete XML

        $this->artisan('app:all', ['path' => storage_path('app/test.xml')])
            ->expectsOutput('An error occurred while processing the XML file: Malformed XML.')
            ->assertExitCode(1);
    }
}