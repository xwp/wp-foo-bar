/**
 * Internal dependencies
 */
import { registerBlocks } from '../../../assets/src/block-editor/helpers';

const mockRegisterBlockType = jest.fn();
jest.mock( '@wordpress/blocks', () => {
	return {
		registerBlockType: ( ...args ) => mockRegisterBlockType( ...args ),
	};
} );

const firstSettings = { title: 'Foo' };

const secondSettings = { title: 'Baz' };

const mockBlocks = {
	'blocks/foo/index.js': firstSettings,
	'block/baz/index.js': secondSettings,
};

// Mocks the require.context() Webpack function.
const mockBlocksToRegister = modulePath => {
	return mockBlocks[ modulePath ];
};

mockBlocksToRegister.keys = () => {
	return Object.keys( mockBlocks );
};

describe( 'registerBlocks', () => {
	it( 'registers the blocks', () => {
		registerBlocks( mockBlocksToRegister );
		expect( mockRegisterBlockType ).toHaveBeenNthCalledWith(
			1,
			'foo',
			firstSettings
		);

		expect( mockRegisterBlockType ).toHaveBeenNthCalledWith(
			2,
			'baz',
			secondSettings
		);
	} );
} );
