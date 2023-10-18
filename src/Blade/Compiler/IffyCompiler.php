<?php

namespace Iffy\Blade\Compiler;

use Iffy\Bin\IffyUtils as Utils;

class IffyCompiler {

    private $closures = array(
        /* Tag Attribute */
        ['/((\w|\_|\-)+[^\s])=\"/', '/(.+?)\"/'],
        /* Raw Variable */
        ['/\$/', '/\s/'],
        /* Raw Echo */
        ['/{!!/', '/!!}/'],
        /* Regular Echo */
        ['/{{/', '/}}/'],
        /* Escaped Echo */
        ['/{{{/', '/}}}/'],
    );

    public function __construct(string $html)
    {
        $this->getVariables($html);
    }

    protected function getVariables(string $html = "") {
        if ( empty($html) ) { return $html; }

        /* The one below is just to show how you can use the config instead (path -> iffy(root folder)/config/config.php) */

        /*
        foreach ( config('iffy.closures') as $closure ) {
            $list = Utils::inbetween($html, $closure);
            var_dump($list);
        }
        */

        foreach ( $this->closures as $closure ) {
            $list = Utils::inbetween($html, $closure);
            var_dump($list);
        }

        return $html;
    }

}