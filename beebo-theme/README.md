# README

## Overview

This document describes how to create a "beebo" WordPress theme: a [child
theme](https://developer.wordpress.org/themes/advanced-topics/child-themes/) of
[twentynineteen](https://wordpress.org/themes/twentynineteen/) with a few
customizations of fonts and so forth, made to be compatible with AMP via
<https://amp-wp.org/>.

There are two broad steps: (1) generate the customised version of the
`twentynineteen` CSS (fairly straightforward) then; (2) pipe it through a
WordPress instance to remove non-AMP compatible constructs (hard).

It would be useful it if wasn't necessary to get a version of WordPress going to
do step (2), but I don't know how to to this...

### Generate the theme

```sh
./build # generates beebo.zip in the current directory
```

### Start a Docker container running WordPress

```sh
docker-compose up -d # starts WordPress on http://localhost:8000
```

### Login to the WordPress instance

```sh
open http://localhost:8000
```

### Install the [AMP WordPress Plugin](https://wordpress.org/plugins/amp/)

The following [link](http://localhost:8000/wp-admin/plugin-install.php?tab=plugin-information&plugin=amp&TB_iframe=true&width=600&height=550) might work:

```sh
open http://localhost:8000/wp-admin/plugin-install.php?tab=plugin-information&plugin=amp&TB_iframe=true&width=600&height=550
```

If not either search for the plugin in the WordPress interface, or install via
uploading the zip file.

### Configure the AMP Plugin

Either choose `AMP | General` in the menu, or go to
<http://localhost:8000/wp-admin/admin.php?page=amp-options> and set Website Mode
to "Standard."

### Install the "Beebo" theme

Upload the `beebo.zip` as generated in (1) via [Add
Themes](http://localhost:8000/wp-admin/theme-install.php?browse=featured) and
activate it.

### Extract the transformed and manipulated CSS

Load <http://localhost:8000/> and copy the CSS from the `<style amp-custom>...</style>`.

### Stop the Docker container

```sh
docker-compose down
```

## More Info

* **For high-level configuration (e.g. fonts)**, check
  `wp-content/themes/twentynineteen/sass/variables-sites`, especially
  [`_fonts.scss`](https://github.com/WordPress/WordPress/blob/master/wp-content/themes/twentynineteen/sass/variables-site/_fonts.scss)
  and
  [`_colors.scss`](https://github.com/WordPress/WordPress/blob/master/wp-content/themes/twentynineteen/sass/variables-site/_colors.scss).
* For info on **what styles/templates are "supported" by the generated CSS**,
  you'll need to look at either the generated HTML (i.e. use WordPress to
  create a sample page, inspect the generated HTML), or the PHP source code. (There's no CSS common across all WordPress themes, although many are based on [`_s`](https://github.com/automattic/_s).)
  * For example,
  [`page.php`](https://github.com/WordPress/WordPress/blob/master/wp-content/themes/twentynineteen/page.php)
  contains the (fairly readable) PHP code that generates a "page", including
  the classes that may be output in various situations.
* To figure out which CSS classes and ids can be removed (because they don't
  affect styling), see the scripts at
  <https://gist.github.com/ithinkihaveacat/ea5893df1024dcf9ba253e99abbe34c7> and info at <https://stackoverflow.com/a/55436077/11543>.
* See the
  [sanitizers](https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/)
  directory of the AMP WordPress plugin for info on what transformations are
  necessary to make `twentynineteen` AMP-compatible.
  * For example, [`class-amp-core-theme-sanitizer.php`](https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/class-amp-core-theme-sanitizer.php), [`class-amp-style-sanitizer.php`](https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/class-amp-style-sanitizer.php).
* **Trouble debugging?** See [I make changes and nothing happens](https://wordpress.org/support/article/i-make-changes-and-nothing-happens/).
* **[Finding Your CSS Styles](https://codex.wordpress.org/Finding_Your_CSS_Styles)**
