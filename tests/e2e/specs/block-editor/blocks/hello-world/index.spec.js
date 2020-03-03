/**
 * WordPress dependencies
 */
import { createNewPost, insertBlock } from '@wordpress/e2e-test-utils';

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
