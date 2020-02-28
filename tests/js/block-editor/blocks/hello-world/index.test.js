/**
 * External dependencies
 */
import { render } from '@testing-library/react';

/**
 * Internal dependencies
 */
import { Edit, Save } from '../../../../../assets/src/block-editor/blocks/hello-world/';

describe( 'Components render as expected', () => {
	it.each( [
		[ Edit, 'Hello Editor' ],
		[ Save, 'Hello Website' ],
	] )( 'Has the proper tag and text', ( Component, text ) => {
		render( <Component /> );
		const expectedTagName = 'h2';
		const tag = document.querySelector( expectedTagName );

		expect( tag.textContent ).toStrictEqual( text );
	} );
} );
