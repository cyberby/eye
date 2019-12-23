<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testListModels(){
        $response = $this->get("metas");
        $metas = $response->json();
        $this->assertEquals("Site", $metas['data'][0]['model']);
        $this->assertEquals("User", $metas['data'][1]['model']);
    }

    public function testListFieldsOfSites(){
        $model_name = "Site";
        $response = $this->get("metas?model_name=".$model_name);
        $fields = $response->json();
        $this->assertGreaterThan(0, $fields['data'][0]['id']);
    }

    public function testListFieldsOfUsers(){
        $model_name = "User";
        $response = $this->get("metas?model_name=".$model_name);
        $fields = $response->json();
        $this->assertGreaterThan(0, $fields['data'][0]['id']);
    }

}
