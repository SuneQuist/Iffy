# Iffy package?

This package can be used to access the blade views before compiled (*ahem* fully compiled).
And comes with some of my own randomly made up Utils like the inBetween function found in the file:
    - src/Bin/IffyUtils.php

It's a stack (algorithm) based regex function. You give it an opening and a closing regex, 
where it will then try to find all the matches, and all the data inbetween those two regex'. 
The reason it's a stack based regex is so it can filter them in the correct order, so you 
don't have to worry about it, not being able to find the correct matches, even if they are enclosed 
multiple times inside the same ascii characters.

## This isn't a package but...

You can download it as a ZIP file, and put it basically anywhere on your pc, 
as long, as you use Sage/Laravel(/Acorn), and have the WP CLI or some other
tool that can discover a package for you, and symlink it. 

### Downloading it, and setting it up.

First download it and place it somewhere, now copy the folders path (you can just use the "pwd" command).

Now in your composer.json file, add this is in. Basically anywhere within the first scope/pair of brackets.

```json
  "repositories": [
    {
      "type": "path",
      "url": "(Somewhere on my PC)/Packages/iffy",
      "options": {
        "symlink": true
      }
    }
  ]
````

Now you'll have to add it as a @dev require package like so:

```json
  "require": {
    "php": "^8.0",
    "roots/acorn": "^3.2",
    "sune/iffy": "@dev" /* <- this is the name of "package", or rather the "name" in the compoer.json file. */
  }
```

### Making the package known to the current project.

Here's a step-by-step command guide:

Step-1: (update the composer and vendor)
```bash
composer update && composer dump-autoload
```

Step-2: (build with yarn og npm) - basically whatever builds your public/dist/etc... folder,
or sets you into developer mode. Most likely one of the four below commands.
```bash
yarn build
yarn dev
npm run build
npm run start
```

Step-3: Discover the package (if you are using Wordpress CLI).
```bash
wp acorn package:discover
```

And yeah. It should work now?
Well since it's a precompiler it'll only show inbetween the reloads, so if you reload once
after making a change in a the blade view, you'll see the var_dump($list) (path -> src/Blade/Compiler/IffyCompiler.php).
But if you reload right after, it won't show.