<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Tests\Browser\Pages\HomePage;

class HomeTest extends DuskTestCase
{
    public function test_it_says_antvel_on_the_power_by_section()
    {
        $this->browse(function ($browser) {
                $browser->visit(new HomePage)
                	->assertSee('Antvel');
        });
    }
}
