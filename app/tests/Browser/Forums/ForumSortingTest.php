<?php

namespace Tests\Browser;

use App\Forum;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumSortingTest extends DuskTestCase
{
        public function setUp()
        {
            parent::setUp();
            $this->thread = factory('App\Thread')->create();
        }

        public function testForumsAreSortedByHighestPriorityFirst()
        {
            $prioritySortedForumsFromDB = Forum::orderBy('priority', 'desc')
                                        ->get();
            $this->browse(function($browser) {
                $forumsOnPage = [];
                $last_val = 0;
                $browser->visit('/forum');
                $browser->with('#forums [name="forum_name"]', function($row) {
                    $row->assertValue('a', $prioritySortedForumsFromDB[$last_val]);
                    $last_val++;
                });
            });
        }
}
