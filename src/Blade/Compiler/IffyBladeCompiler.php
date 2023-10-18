<?php

namespace Iffy\Blade\Compiler;

use Iffy\Iffy;
use Iffy\Blade\Compiler\IffyCompiler;

class IffyBladeCompiler extends Iffy {
    public function __construct()
    {
        $closure = function ($html) {
            return $this->compiler($html);
        };

        $this->blade()->precompiler($closure);
    }

    protected function compiler($html)
    {
        new IffyCompiler($html);
        return $html;
    }
}