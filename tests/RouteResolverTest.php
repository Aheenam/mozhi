<?php
namespace Aheenam\Mozhi\Test;

use Aheenam\Mozhi\Models\Page;
use Aheenam\Mozhi\RouteResolver;

class RouteResolverTest extends TestCase
{

    /** @test */
    public function it_returns_a_page_by_route ()
    {

        $page = (new RouteResolver)->getPageByRoute('/blog/awesome-blog');

        $this->assertNotNull($page);
        $this->assertInstanceOf(Page::class, $page);
    }

    /** @test */
    public function it_returns_null_if_page_does_not_exists ()
    {
        $page = (new RouteResolver)->getPageByRoute('/blog/yet-another-awesome-blog');

        $this->assertNull($page);
    }

}