<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
         DB::table("metas")->distinct()->get();
//        $this->assertTrue(true);
    }
}
