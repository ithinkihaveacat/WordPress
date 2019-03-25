## Overview

This document describes how to create a "beebo" WordPress theme: a [child
theme](https://developer.wordpress.org/themes/advanced-topics/child-themes/) of
[twentynineteen](https://wordpress.org/themes/twentynineteen/) with a few
customizations of fonts and so forth, made to be compatible with AMP via
<https://amp-wp.org/>.

There are two broad steps: (1) generate the customised version of the
`twentynineteen` CSS (fairly straightforward) then; (2) pipe it through a
WordPress instance to ensure all necessary transformations are applied (hard).

It would be useful it if wasn't necessary to get a version of WordPress going to
do step (2), but I don't know how to to this...

1.

**Generate the theme**

```sh
$ ./build.sh # generates beebo.zip in the current directory
```

2.

**Start a Docker container running WordPress**

```sh
$ `docker-compose up -d` # starts WordPress on http://localhost:8000
```

3.

**Login to the WordPress instance**

```sh
$ open http://localhost:8000
```

4.

**Install the [AMP WordPress Plugin](https://wordpress.org/plugins/amp/)**

The following link might work:

```sh
$ open http://localhost:8000/wp-admin/plugin-install.php?tab=plugin-information&plugin=amp&TB_iframe=true&width=600&height=550
```

If not either search for the plugin in the WordPress interface, or install via
uploading the zip file. 

5.

**Configure the AMP Plugin**

Either choose `AMP | General` in the menu, or go to <http://localhost:8000/wp-admin/admin.php?page=amp-options>:

  * Template Mode:
    * Set to "Native"
  * Validation Handling:
    * Disable "Automatically remove CSS rules"
    * Enable "Disable admin bar on AMP pages"

6.

**Install the "Beebo" theme**

Upload the `beebo.zip` as generated in (1).

7.

**Extract the transformed and manipulated CSS**

Load <http://localhost:8000/> and copy the CSS from the `<style amp-custom>...</style>`.

8.

**Stop the Docker container**

```sh
$ docker-compose down
```

## More Info

Useful files:

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
  * See the
    [sanitizers](https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/)
    directory of the AMP WordPress plugin for info on what transformations are
    necessary to make `twentynineteen` AMP-compatible.
    * For example, [`class-amp-core-theme-sanitizer.php`](https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/class-amp-core-theme-sanitizer.php), [`class-amp-style-sanitizer.php`](https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/class-amp-style-sanitizer.php).
  * **Trouble debugging?** See [I make changes and nothing happens](https://wordpress.org/support/article/i-make-changes-and-nothing-happens/).
  * **[Finding You CSS Styles](https://codex.wordpress.org/Finding_Your_CSS_Styles)**
