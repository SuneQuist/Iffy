<?php

namespace Iffy;

use Illuminate\Support\Arr;
use Roots\Acorn\Application;
use Iffy\Blade\Compiler\IffyBladeCompiler;

class Iffy
{
    /**
     * The application instance.
     *
     * @var \Roots\Acorn\Application
     */
    protected $app;

    /**
     * Create a new Iffy instance.
     *
     * @param  \Roots\Acorn\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        if ( $this->blade() ) {
            new IffyBladeCompiler();
        }
    }

    /**
     * Returns the Blade compiler if it exists.
     * @return \Illuminate\Support\Facades\Blade
     */
    public function blade()
    {
        $sage = "\\App\\sage";

        if (function_exists($sage)) {
            return $sage('blade')->compiler();
        }

        if (function_exists('Roots\app')) {
            return \Roots\app('blade.compiler');
        }
    }
}
