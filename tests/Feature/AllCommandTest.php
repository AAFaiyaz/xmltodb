<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AllCommandTest extends TestCase
{
    public function test_it_can_process_a_valid_xml_file()
    {
        $this->artisan('app:all', ['path' => 'valid.xml'])
            ->expectsOutput('Successfully processed the XML file and stored the data in the database.')
            ->assertExitCode(0);
    }

    public function test_it_can_handle_a_missing_xml_file()
    {
        $this->artisan('app:all', ['path' => 'missing.xml'])
            ->expectsOutput('An error occurred while processing the XML file: Unable to open file.')
            ->assertExitCode(1);
    }

    public function test_it_can_handle_a_malformed_xml_file()
    {
        $this->artisan('app:all', ['path' => 'malformed.xml'])
            ->expectsOutput('An error occurred while processing the XML file: Malformed XML.')
            ->assertExitCode(1);
    }
}