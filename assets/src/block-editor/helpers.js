// On running npm run dev, this will compile to assets/js/.

/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Registers
 *
 * @param {Object} blocks The blocks to register.
 */
export const registerBlocks = blocks => {
	blocks.keys().forEach( modulePath => {
		const { name, settings } = blocks( modulePath );

		registerBlockType( name, settings );
	} );
};
