<?php

/* This get's used in the src/Providers/IffyServiceProvider.php */
return [
    /* 
    *   Could put the src/Blade/Compiler/IffyCompiler.php - private $closures variable here
    *   if you wanted to.
    */
    'closures' => [
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
    ]
];
