/**
 * External dependencies
 */
import { render } from '@testing-library/react';

/**
 * Internal dependencies
 */
import {
	Edit,
	Save,
} from '../../../../../assets/src/block-editor/blocks/hello-world/';

describe( 'Components render as expected', () => {
	it.each( [
		[ Edit, 'Hello Editor' ],
		[ Save, 'Hello Website' ],
	] )( 'has the proper tag and text', ( Component, text ) => {
		render( <Component /> );
		const tag = document.querySelector( 'h2' );

		expect( tag.textContent ).toStrictEqual( text );
	} );
} );
