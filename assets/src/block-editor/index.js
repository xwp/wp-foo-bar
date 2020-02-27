// Add the JS code to this file. On running npm run dev, it will compile to assets/js/.

/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import './edit.css';

registerBlockType( 'foo-bar/hello-world', {
	title: __( 'Hello World', 'foo-bar' ),
	icon: 'smiley',
	category: 'common',

	edit() {
		return <h1>{ __( 'Hello Editor', 'foo-bar' ) }</h1>;
	},

	save() {
		return <h1>{ __( 'Hello Website', 'foo-bar' ) }</h1>;
	},
} );
