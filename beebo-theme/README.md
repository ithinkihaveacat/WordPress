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

Note: if updating the theme, you may have to remove it first via
<http://localhost:8000/wp-admin/themes.php?theme=beebo>.

### Transform the theme

```sh
getcat 'http://localhost:8000' | tr -d '\n' | perl -wpe 's{.*<style amp-custom="">(.*?)</style>.*}{$1}s; s{http://localhost:8000/wp-content/themes/beebo/font/}{/assets/}s;' | pbcopy
```

The two steps this does are:

  1. **Extract the transformed and manipulated CSS**
  1. **Remove "localhost" prefix and adjust font paths**

### Stop the Docker container

```sh
docker-compose down
```

### Destroy the Docker containers

(To wipe the WordPress installation.)

```sh
docker volume prune
```

(State is persisted to the `db_name` volume; this needs to be wiped.)

## More Info

* **For high-level configuration (e.g. fonts)**, check
  `wp-content/themes/twentynineteen/sass/variables-sites`, especially
  [`_fonts.scss`](https://github.com/WordPress/WordPress/blob/master/wp-content/themes/twentynineteen/sass/variables-site/_fonts.scss)
  and
  [`_colors.scss`](https://github.com/WordPress/WordPress/blob/master/wp-content/themes/twentynineteen/sass/variables-site/_colors.scss).
* If custom fonts are loaded via `@font-face`, this will probably be happening in [`_fontface.scss`](https://github.com/WordPress/WordPress/blob/master/wp-content/themes/twentynineteen/sass/typography/_fontface.scss).
* The header "dots" are controlled by the `#page` selector in `_layout.scss`.
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
* Since running `./build` will create a new
  `wp-content/themes/twentynineteen/style.css`, while developing it may be
  useful to get git to ignore any (local) changes to this file via `git
  update-index --skip-worktree wp-content/themes/twentynineteen/style.css`.
* For "live" editing and debugging, use the "Theme Editor" section of the
  "Appearance" menu. This lets you edit the generated CSS, for example.
