## Overview

This document describes how to create a "beebo" WordPress theme: a [child
theme](https://developer.wordpress.org/themes/advanced-topics/child-themes/) of
[twentynineteen](https://wordpress.org/themes/twentynineteen/) with a few
customizations of fonts and so forth, made to be compatible with AMP via
<https://amp-wp.org/>.

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

## Details

Useful SCSS files:

  * A few files in `wp-content/themes/twentynineteen/sass/veriables-sites`,
    especially `_fonts.scss` and `_colors.scss`.

The [AMP WordPress Plugin](https://wordpress.org/plugins/amp/) does various
transformation of the CSS to make `twentynineteen` AMP-compatible, among them:

  * <https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/class-amp-core-theme-sanitizer.php>
  * <https://github.com/ampproject/amp-wp/blob/develop/includes/sanitizers/class-amp-style-sanitizer.php>