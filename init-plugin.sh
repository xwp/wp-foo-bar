#!/bin/bash
# Usage: ./wp-foo-bar/init-plugin.sh

# Check for valid plugin name.
function valid_name () {
	valid="^[A-Z][A-Za-z0-9]*( [A-Z][A-Za-z0-9]*)*$"

	if [[ ! "$1" =~ $valid ]]; then
		return 1
	fi

	return 0
}

echo
echo "Hello, "$USER"."
echo
echo "This script will automatically generate a new plugin based on the scaffolding."
echo "The way it works is you enter a plugin name like 'Hello World' and the script "
echo "will create a directory 'hello-world' in the current working directory, while "
echo "performing substitutions on the 'wp-foo-bar' scaffolding plugin."
echo

echo -n "Enter your plugin name and press [ENTER]: "
read name

# Validate plugin name.
if ! valid_name "$name"; then
	echo "Malformed name '$name'. Please use title case words separated by spaces. No hyphens. For example, 'Hello World'."
	echo
	echo -n "Enter a valid plugin name and press [ENTER]: "
	read name

	if ! valid_name "$name"; then
		echo
		echo "The name you entered is invalid, rage quitting."
		exit 1
	fi
fi

slug="$( echo "$name" | tr '[:upper:]' '[:lower:]' | sed 's/ /-/g' )"
prefix="$( echo "$name" | tr '[:upper:]' '[:lower:]' | sed 's/ /_/g' )"
namespace="$( echo "$name" | sed 's/ //g' )"
class="$( echo "$name" | sed 's/ /_/g' )"
repo="$slug"

echo
echo "The Organization name will be converted to lowercase for use in the repository "
echo "path (i.e. XWP becomes xwp)."
echo -n "Enter your GitHub organization name, and press [ENTER]: "
read org

org_lower="$( echo "$org" | tr '[:upper:]' '[:lower:]' )"

echo
echo -n "Do you want to prepend 'wp-' to your repository name? [Y/N]: "
read prepend

if [[ "$prepend" != Y ]] && [[ "$prepend" != y ]]; then
	echo
	echo -n "Do you want to append '-wp' to your repository name? [Y/N]: "
    read append

	if [[ "$append" == Y ]] || [[ "$append" == y ]]; then
		repo="${slug}-wp"
	fi
else
	repo="wp-${slug}"
fi

echo
echo -n "Do you want to push the plugin to your GitHub repository? [Y/N]: "
read push

echo

cwd="$(pwd)"
cd "$(dirname "$0")"
src_repo_path="$(pwd)"
cd "$cwd"

if [[ -e $( basename "$0" ) ]]; then
    echo
	echo "Moving up one directory outside of 'wp-foo-bar'"
	cd ..
fi

if [[ -e "$slug" ]]; then
    echo
	echo "The $slug directory already exists"
	exit 1
fi

echo

git clone "$src_repo_path" "$repo"

cd "$repo"

git mv foo-bar.php "$slug.php"
git mv tests/phpunit/class-test-foo-bar.php "tests/phpunit/class-test-$slug.php"

git grep -lz "xwp" | xargs -0 sed -i '' -e "s/xwp/$org_lower/g"
git grep -lz "wp-foo-bar" | xargs -0 sed -i '' -e "s/wp-foo-bar/$repo/g"
git grep -lz "Foo Bar" | xargs -0 sed -i '' -e "s/Foo Bar/$name/g"
git grep -lz "foo-bar" | xargs -0 sed -i '' -e "s/foo-bar/$slug/g"
git grep -lz "foo_bar" | xargs -0 sed -i '' -e "s/foo_bar/$prefix/g"
git grep -lz "FooBar" | xargs -0 sed -i '' -e "s/FooBar/$namespace/g"
git grep -lz "Foo_Bar" | xargs -0 sed -i '' -e "s/Foo_Bar/$class/g"

# Clean slate.
rm -rf .git
rm -rf node_modules
rm -rf vendor
rm -f init-plugin.sh
rm -f composer.lock
rm -f package-lock.json

# Setup Git.
git init
git add .
git commit -m "Initial commit"
git remote add origin "git@github.com:$org_lower/$repo.git"

# Install dependencies.
if [[ -f package.json ]]; then
    npm install
else
    composer install
fi

if [[ "$push" == Y ]] || [[ "$push" == y ]]; then
    git push -u origin master
else
    echo
    echo "Push changes to GitHub with the following command:"
    echo "cd $(pwd) && git push -u origin master"
fi

echo
echo "Plugin is located at:"
pwd
