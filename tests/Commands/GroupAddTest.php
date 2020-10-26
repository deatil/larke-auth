<?php

namespace Larke\Auth\Tests\Commands;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Larke\Auth\Facades\Enforcer;
use Larke\Auth\Tests\TestCase;

class GroupAddTest extends TestCase
{
    use DatabaseMigrations;

    public function testHandle()
    {
        $this->assertFalse(Enforcer::hasGroupingPolicy('eve', 'writer', 'domain'));

        $exitCode = Artisan::call('group:add', ['policy' => 'eve, writer, domain']);
        $this->assertTrue(0 === $exitCode);
        $this->assertTrue(Enforcer::hasGroupingPolicy('eve', 'writer', 'domain'));

        $exitCode = Artisan::call('group:add', ['policy' => 'eve, writer, domain']);
        $this->assertFalse(0 === $exitCode);
    }
}
