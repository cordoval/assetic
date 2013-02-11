<?php

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2013 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Assetic\Test\Util;

use Assetic\Util\CssUtils;

class CssUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetReferences()
    {
        // These don't work yet:
        // @import url("fineprint.css") print;
        // @import url("bluish.css") projection, tv;
        // @import url('landscape.css') screen and (orientation:landscape);

        $content = <<<CSS
@import 'custom.css';
@import "common.css" screen, projection;
body { background: url(../images/bg.gif); }
.something { background: url(../images/bg.gif); }
CSS;

        $expected = array('../images/bg.gif', 'common.css', 'custom.css');
        $actual = CssUtils::extractReferences($content);

        $this->assertEquals($expected, array_intersect($expected, $actual), '::extractReferences() returns all expected URLs');
        $this->assertEquals(array(), array_diff($actual, $expected), '::extractReferences() does not return unexpected URLs');
    }
}
