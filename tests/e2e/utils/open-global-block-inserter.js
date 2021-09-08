/* global page */

/**
 * Opens the global block inserter.
 */
export async function openGlobalBlockInserter() {
	if ( ! ( await isGlobalInserterOpen() ) ) {
		await toggleGlobalBlockInserter();

		// Waiting here is necessary because sometimes the inserter takes more time to
		// render than Puppeteer takes to complete the 'click' action
		await page.waitForSelector( '.block-editor-inserter__toggle' );
	}
}

export async function closeGlobalBlockInserter() {
	if ( await isGlobalInserterOpen() ) {
		await toggleGlobalBlockInserter();
	}
}

async function isGlobalInserterOpen() {
	return await page.evaluate( () => {
		return !! document.querySelector(
			'.edit-post-header-toolbar__inserter-toggle.is-pressed'
		);
	} );
}

async function toggleGlobalBlockInserter() {
	await page.click( '.edit-post-header-toolbar__inserter-toggle' );
}
