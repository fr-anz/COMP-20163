<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_reports_readiness_without_authentication(): void
    {
        $this->getJson('/')
            ->assertOk()
            ->assertExactJson(['name' => 'E-Commerce API', 'status' => 'ready']);
    }

    public function test_the_framework_health_route_is_public(): void
    {
        $this->get('/up')->assertOk();
        $this->getJson('/up')->assertOk()->assertExactJson(['status' => 'up']);
    }
}
