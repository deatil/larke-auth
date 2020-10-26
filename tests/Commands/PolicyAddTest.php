<?php

namespace Larke\Auth\Tests\Commands;

use Larke\Auth\Facades\Enforcer;
use Larke\Auth\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class PolicyAddTest extends TestCase
{
    use DatabaseMigrations;

    public function testHandle()
    {
        $this->assertFalse(Enforcer::enforce('eve', 'articles', 'read'));
        $exitCode = Artisan::call('policy:add', ['policy' => 'eve, articles, read']);
        $this->assertTrue(0 === $exitCode);
        $this->assertTrue(Enforcer::enforce('eve', 'articles', 'read'));

        $exitCode = Artisan::call('policy:add', ['policy' => 'eve, articles, read']);
        $this->assertFalse(0 === $exitCode);
    }
}
