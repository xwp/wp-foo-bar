=== Foo Bar ===
Contributors: xwp
Requires at least: 5.0
Tested up to: 5.3.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Template plugin for scaffolding WordPress plugins at XWP.

== Description ==

Use the [`init-plugin.sh`](init-plugin.sh) bash script to enter an interactive shell on your system, which attempts to copy this repo while making necessary string replacements:

```bash
./init-plugin.sh
```

The `init-plugin.sh` script will be removed from the generated plugin. You should also update your new `readme.txt` and add any config files your project may need, read more about your options in the [`xwp/wp-dev-lib/readme.md`](https://github.com/xwp/wp-dev-lib) file.

**Coveralls Pro**

To use Coveralls Pro with your private repository you will need to change the `service_name` inside `.coveralls.yml` to `travis-pro`, and add the `COVERALLS_REPO_TOKEN` to the settings in Travis CI.

== Installation ==

1. Upload the folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

== Getting Started ==

If you are a developer, we encourage you to [follow along](https://github.com/xwp/wp-foo-bar) or [contribute](https://github.com/xwp/wp-foo-bar/blob/develop/contributing.md) to the development of this plugin on GitHub.

== Screenshots ==

1. Look at this demo photo!

== Changelog ==

For the plugin’s changelog, please see [the Releases page on GitHub](https://github.com/xwp/wp-foo-bar/releases).
