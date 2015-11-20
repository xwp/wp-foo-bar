#!/bin/bash
# Usage: ./init-plugin.sh "Hello World"
# Creates a subdirectory "hello-world" in the current working directory, 
# performing substitutions on the scaffold "foo-bar" plugin at https://github.com/xwp/wp-foo-bar

set -e

if [ $# != 1 ]; then
	echo "You must only supply one argument, the plugin name."
	exit 1
fi

name="$1"
if [ -z "$name" ]; then
	echo "Provide name argument"
	exit 1
fi

if ! perl -pe '/^[A-Z][a-z0-9]*( [A-Z][a-z0-9]*)*$/ || exit 1;' > /dev/null <<< "$name"; then
	echo "Malformed name argument '$name'. Please use title case words separated by spaces. No hypens."
	exit 1
fi

slug=$( perl -pe '$_ = lc; s/ /-/g' <<< "$name" )
prefix=$( perl -pe '$_ = lc; s/ /_/g' <<< "$name" )
namespace=$( perl -pe 's/ //g' <<< "$name" )
class=$( perl -pe 's/ /_/g' <<< "$name" )

echo "Name: $name"
echo "Slug: $slug"
echo "Prefix: $prefix"
echo "NS: $namespace"
echo "Class: $class"

if [ -e "$slug" ]; then
	echo "Directory already exists"
	exit
fi

git clone --recursive https://github.com/xwp/wp-foo-bar.git "$slug"

cd "$slug"

# Update dev-lib to latest
cd dev-lib
git pull origin master
cd ..

git mv foo-bar.php "$slug.php"
cd tests
git mv test-foo-bar.php "test-$slug.php"
cd ..

perl -p -i'' -e "s/Foo Bar/$name/g" $( find */ -type f ) *.*
perl -p -i'' -e "s/foo-bar/$slug/g" $( find */ -type f  ) *.*
perl -p -i'' -e "s/foo_bar/$prefix/g" $( find */ -type f ) *.*
perl -p -i'' -e "s/FooBar/$namespace/g" $( find */ -type f ) *.*
perl -p -i'' -e "s/Foo_Bar/$class/g" $( find */ -type f ) *.*
if [ -e phpunit.xml.dist ]; then
    # sed destroys the symlink
    git checkout phpunit.xml.dist
fi

git remote set-url origin "https://github.com/xwp/wp-$slug.git"
if [ -e init-plugin.sh ]; then
	git rm -f init-plugin.sh
fi
git add -A .
git reset --soft $( git rev-list HEAD | tail -n 1 )
git commit --amend -m "Initial commit"
