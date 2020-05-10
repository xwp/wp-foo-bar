/**
 * WordPress dependencies
 */
import { createNewPost } from '@wordpress/e2e-test-utils';

/**
 * Internal dependencies.
 */
import { insertBlock } from '../../../../utils';

describe( 'blocks: foo-bar/hello-world', () => {
	beforeEach( async () => {
		await createNewPost( {} );
	} );

	it( 'should be inserted', async () => {
		await insertBlock( 'Hello World' );

		// Check if block was inserted
		expect(
			await page.$( '[data-type="foo-bar/hello-world"]' )
		).not.toBeNull();
	} );
} );
