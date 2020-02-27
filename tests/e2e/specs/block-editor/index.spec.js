import { createNewPost, insertBlock } from '@wordpress/e2e-test-utils';

describe( 'Wrapper block', () => {
	beforeEach( async () => {
		await createNewPost( {} );
	} );

	it( 'Hello World block should be available', async () => {
		await insertBlock( 'Hello World' );

		// Check if block was inserted
		expect(
			await page.$( '[data-type="foo-bar/hello-world"]' )
		).not.toBeNull();
	} );
} );
