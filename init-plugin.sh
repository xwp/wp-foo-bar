#!/bin/bash
# Usage: ./foo-bar/init-plugin.sh xwp "Hello World"
# Creates a directory "hello-world" in the current working directory,
# performing substitutions on the scaffold "foo-bar" plugin at https://github.com/xwp/wp-foo-bar

set -e

if [ $# != 2 ]; then
	echo "You must supply two arguments, the github username or organization and plugin name."
	exit 1
fi

user="$1"
if [ -z "$user" ]; then
	echo "Provide github username or organization argument"
	exit 1
fi

name="$2"
if [ -z "$name" ]; then
	echo "Provide name argument"
	exit 1
fi

valid="^[A-Z]*[a-z0-9]*( [A-Z]*[a-z0-9]*)*$"
if [[ ! "$name" =~ $valid ]]; then
	echo "Malformed name argument '$name'. Please use title case words separated by spaces. No hyphens."
	exit 1
fi

slug="$( echo "$name" | tr '[:upper:]' '[:lower:]' | sed 's/ /-/g' )"
prefix="$( echo "$name" | tr '[:upper:]' '[:lower:]' | sed 's/ /_/g' )"
namespace="$( echo "$name" | sed 's/ //g' )"
class="$( echo "$name" | sed 's/ /_/g' )"

cwd="$(pwd)"
cd "$(dirname "$0")"
src_repo_path="$(pwd)"
cd "$cwd"

if [[ -e $( basename "$0" ) ]]; then
	echo "Moving up one directory outside of foo-bar"
	cd ..
fi

if [ -e "$slug" ]; then
	echo "The $slug directory already exists"
	exit
fi

echo "Name: $name"
echo "Slug: $slug"
echo "Prefix: $prefix"
echo "NS: $namespace"
echo "Class: $class"

git clone "$src_repo_path" "$slug"

cd "$slug"

git mv foo-bar.php "$slug.php"
cd tests
git mv class-test-foo-bar.php "class-test-$slug.php"
cd ..

git grep -lz "xwp/wp-foo-bar" | xargs -0 sed -i '' -e "s/xwp\/wp-foo-bar/$user\/$slug/g"
git grep -lz "xwp" | xargs -0 sed -i '' -e "s/xwp/$user/g"
git grep -lz "$user/wp-dev-lib" | xargs -0 sed -i '' -e "s/$user\/wp-dev-lib/xwp\/wp-dev-lib/g"
git grep -lz "vendor/$user" | xargs -0 sed -i '' -e "s/vendor\/$user/vendor\/xwp/g"
git grep -lz "$user/wordpress-tests-installer" | xargs -0 sed -i '' -e "s/$user\/wordpress-tests-installer/xwp\/wordpress-tests-installer/g"
git grep -lz "$user.co" | xargs -0 sed -i '' -e "s/$user.co/xwp.co/g"
git grep -lz "Foo Bar" | xargs -0 sed -i '' -e "s/Foo Bar/$name/g"
git grep -lz "foo-bar" | xargs -0 sed -i '' -e "s/foo-bar/$slug/g"
git grep -lz "foo_bar" | xargs -0 sed -i '' -e "s/foo_bar/$prefix/g"
git grep -lz "FooBar" | xargs -0 sed -i '' -e "s/FooBar/$namespace/g"
git grep -lz "Foo_Bar" | xargs -0 sed -i '' -e "s/Foo_Bar/$class/g"

rm -rf .git
rm -rf vendor
rm -f init-plugin.sh

git init
git add -A .
git commit -m "Initial commit"
git remote add origin "git@github.com:$user/$slug.git"
git push -u origin master

composer install

echo "Plugin is located at:"
pwd
