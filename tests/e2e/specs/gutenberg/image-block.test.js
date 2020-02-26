/**
 * WordPress dependencies
 */
import { createNewPost, insertBlock } from '@wordpress/e2e-test-utils';
import { clickButton } from '../../utils';

const MEDIA_LIBRARY_BUTTON = '.editor-media-placeholder__media-library-button';

describe( 'Image Block', () => {
	beforeEach( async () => {
		await createNewPost( {} );
	} );

	it( 'the Media Library tab should exist', async () => {
		await insertBlock( 'Image' );
		// Click the media library button.
		await page.waitForSelector( MEDIA_LIBRARY_BUTTON );
		//await page.click( MEDIA_LIBRARY_BUTTON );
		await clickButton( 'Media Library' );
		await page.waitForSelector( '.media-modal' );
		await page.waitForSelector( '#menu-item-browse' );
		await expect( page ).toMatchElement( '#menu-item-browse' );
	} );
} );
