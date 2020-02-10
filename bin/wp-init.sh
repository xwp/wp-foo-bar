# Install WP
echo "Site URL: http://localhost:${WORDPRESS_HTTP_PORT}"
wp core install --url="localhost:${WORDPRESS_HTTP_PORT}" --title=FooBar --admin_user=admin --admin_password=admin --admin_email=admin@example.com --allow-root

# Install Classic Editor
wp plugin install classic-editor --activate --allow-root