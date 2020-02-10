/* eslint-env node */

module.exports = function( grunt ) {
	'use strict';

	grunt.initConfig( {

		// Build a deploy-able plugin.
		copy: {
			build: {
				src: [
					'**',
					'!.*',
					'!.*/**',
					'!.DS_Store',
					'!assets/css/src/**',
					'!assets/js/.gitignore',
					'!assets/src/**',
					'!bin/**',
					'!build/**',
					'!built/**',
					'!code_of_conduct.md',
					'!contributing/**',
					'!composer.json',
					'!composer.lock',
					'!contributing.md',
					'!docker-compose.yml',
					'!Gruntfile.js',
					'!jest.config.js',
					'!node_modules/**',
					'!npm-debug.log',
					'!package.json',
					'!package-lock.json',
					'!phpcs.xml',
					'!phpunit.xml',
					'!readme.md',
					'!renovate.json',
					'!tests/**',
					'!vendor/**',
					'!webpack.config.js'
				],
				dest: 'build',
				expand: true,
				dot: true
			}
		},

		// Clean up the build.
		clean: {
			compiled: {
				src: [ 'assets/js/*.js', '!assets/js/admin.js', 'assets/js/*.asset.php' ],
			},
			build: {
				src: [ 'build' ]
			}
		},

		// Shell actions.
		shell: {
			options: {
				stdout: true,
				stderr: true
			},
			readme: {
				command: './vendor/xwp/wp-dev-lib/scripts/generate-markdown-readme' // Generate the readme.md.
			},
			create_build_zip: {
				command: 'if [ ! -e build ]; then echo "Run grunt build first."; exit 1; fi; if [ -e foo-bar.zip ]; then rm foo-bar.zip; fi; cd build; zip -r ../foo-bar.zip .; cd ..; echo; echo "ZIP of build: $(pwd)/foo-bar.zip"',
			},
		},

		// Deploys a git Repo to the WordPress SVN repo.
		wp_deploy: {
			deploy: {
				options: {
					plugin_slug: 'foo-bar',
					build_dir: 'build',
				  	assets_dir: 'wp-assets'
				}
			}
		}

	} );

	// Load tasks.
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-shell' );
	grunt.loadNpmTasks( 'grunt-wp-deploy' );

	// Register tasks.
	grunt.registerTask( 'default', [
		'build'
	] );

	grunt.registerTask( 'readme', [
		'shell:readme'
	] );

	grunt.registerTask( 'build', [
		'readme',
		'copy'
	] );

	grunt.registerTask( 'create-build-zip', [
		'shell:create_build_zip',
	] );

	grunt.registerTask( 'deploy', [
		'build',
		'wp_deploy',
		'clean'
	] );

};
