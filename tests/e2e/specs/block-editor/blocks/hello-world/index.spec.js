import { createNewPost, insertBlock } from '@wordpress/e2e-test-utils';

describe( 'Hello World block', () => {
	beforeEach( async () => {
		await createNewPost( {} );
	} );

	it( 'should be available', async () => {
		await insertBlock( 'Hello World' );

		// Check if block was inserted
		expect(
			await page.$( '[data-type="foo-bar/hello-world"]' )
		).not.toBeNull();
	} );

	it( 'should have the correct textContent', async () => {
		await insertBlock( 'Hello World' );

		const content = await page.$eval(
			'[data-type="foo-bar/hello-world"] h2',
			node => node.textContent
		);
		expect( content ).toStrictEqual( 'Hello Editor' );
	} );
} );
