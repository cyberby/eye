<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /**
     * This endpoint lists the reports
     */
    public function testIndex(){
        $response = $this->get("reports");
        $this->assertTrue($response->json()['success']);
        $response->assertStatus(200);
    }




    /**
     * This endpoint adds a report.
     */
    public function testAdd()
    {
        $data = [
            'name' => "Test",
            'model'=> 'Site',
            'conditions' => [
                "OR" => [
                    [
                        "AND" => [
                            [
                                'column' => 'YEAR(Site.created_at)',
                                'operator' => "=",
                                'value' => "2019"
                            ],
                            [
                                'column' => 'Site.domain',
                                'operator' => "LIKE",
                                'value' => "%.net"
                            ],
                        ]
                    ],
                    [
                        [
                            'column' => 'Site.domain',
                            'operator' => "LIKE",
                            'value' => "%.com"
                        ]
                    ]
                ]
            ],
            'orders' => [
                'Site.id' => "desc"
            ],
            'joins' => [
                [
                    'type' => "INNER",
                    'model' => "User",
                    'predicant' => 'User.id',
                    'predicate' => 'Site.user_id'
                ]

            ]
        ];
        $response = $this->post("reports", $data);
        $this->assertTrue($response->json()['success']);
        $response->assertStatus(200);
    }

    /**
     * This endpoint runs the report.
     */
    public function testView(){

        $report = DB::table("reports")->get()->first();
        $response = $this->get("reports/".$report->id);
        $this->assertNotEmpty($response->json());
        $response->assertStatus(200);
    }

    /**
     * This endpoint update a report.
     */
    public function testEdit()
    {
        $report = DB::table("reports")->get()->first();
        $data = [
            'name' => "Test Edited",
            'model'=> 'Site',
            'conditions' => [
                "OR" => [
                    [
                        "AND" => [
                            [
                                "model" => "Site",
                                'column' => 'YEAR(Site.created_at)',
                                'operator' => "=",
                                'value' => "2019"
                            ],
                            [
                                "model" => "Site",
                                'column' => 'Site.domain',
                                'operator' => "LIKE",
                                'value' => "%.net"
                            ],
                            [
                                'AND' => [
                                    [
                                        "model" => "Site",
                                        'column' => 'Site.domain',
                                        'operator' => "LIKE",
                                        'value' => "%.net1"
                                    ],
                                    [
                                        "model" => "Site",
                                        'column' => 'Site.domain',
                                        'operator' => "LIKE",
                                        'value' => "%.net2"
                                    ],
                                ]

                            ]
                        ]
                    ],
                    [
                        [
                            "model" => "Site",
                            'column' => 'Site.domain',
                            'operator' => "LIKE",
                            'value' => "%.com"
                        ]
                    ]
                ]
            ],
            'orders' => [
                'Site.id' => "desc"
            ],
            'joins' => [
                [
                    'type' => "INNER",
                    'model' => "User",
                    'predicant' => 'User.id',
                    'predicate' => 'Site.user_id'
                ]

            ]
        ];
        $response = $this->put("reports/".$report->id, $data);
        $this->assertNotEmpty($response->json()['data']);
        $this->assertTrue($response->json()['success']);
        $response->assertStatus(200);
    }

    /**
     * This endpoint delete a report.
     */
    public function testDelete(){
        $report = DB::table("reports")->get()->first();
        $response = $this->delete("reports/".$report->id);
        $this->assertTrue($response->json()['success']);
        $response->assertStatus(200);
    }
}
