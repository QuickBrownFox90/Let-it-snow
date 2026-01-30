# Let it snow WordPress plugin

**Why?** I want it to snow on WordPress pages. There is no deeper reason for this.

## How it works

It's a very simple plugin that adds an HTML `<canvas>` element and a lightweight JavaScript file to create a snow overlay on the frontend. No magic included.

---

## How to install

1. Download the [latest release](https://github.com/QuickBrownFox90/Let-it-snow/releases/tag/v1.0.0)
2. Unzip and upload the folder to your WordPress plugins directory.
3. Alternatively, you can upload the `.zip` file directly via the WordPress backend at `/wp-admin/plugin-install.php`.

---

## How to build

We use the [GRUNT](https://gruntjs.com/) task runner to build the production version.

This requires `yarn` (or `npm`) and `grunt` to be installed on your local machine.

**To get started, clone the project:**

```shell
$ git clone https://github.com/QuickBrownFox90/Let-it-snow.git
```

**Install the dev dependencies:**

```shell
$ yarn install
# or
$ npm install
```

If you are working on the project and want to assign a version number, you can use the helper script `_helper/version.sh` to update it.

*This assumes you are using an operating system capable of executing bash scripts ;)*

```shell
./_helper/version.sh <option>
```

```text
usage: ./version.sh <option>
options: -p, --patch          Patch version
         --minor              Minor version
         --major              Major version
         -v, --version <arg>  Specific version number like '1.12.4'
         -h, --help           Show this help
```

**Finally, create a production build:**

```shell
$ grunt build
```

Once finished, you will find a WordPress-ready `.zip` file inside the `build` directory.

---

## Development

To work on the project, the setup includes `grunt-watch` with *LiveReload* support. The default **grunt** task is `watch`.

Start developing with:

```shell
$ grunt
```

While `grunt-watch` is running, every time you save a `.js` file, Grunt will concatenate all files specified in `_assets/_js.json` into a single JS file in `dist/js/`. If you have `WP_DEBUG` enabled, the *LiveReload* feature will refresh your browser whenever you save a `.php` or `.js` file.

All other Grunt tasks are defined in `gruntfile.js` and the task files in the `_helper/tasks/` directory. In most cases, you will only need `grunt watch` and `grunt build`.