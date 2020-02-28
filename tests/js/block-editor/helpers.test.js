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

const firstName = 'Foo';
const firstSettings = { title: 'Foo' };
const secondName = 'Baz';
const secondSettings = { title: 'Baz' };

const mockBlocks = {
	'blocks/foo/index.js': { name: firstName, settings: firstSettings },
	'block/baz/index.js': { name: secondName, settings: secondSettings },
};

// Mocks the return value of the require.context() Webpack function.
const mockBlocksToRegister = modulePath => {
	return mockBlocks[ modulePath ];
};

mockBlocksToRegister.keys = () => {
	return Object.keys( mockBlocks );
};

describe( 'registerBlocks', () => {
	it( 'registers all of the expected blocks, with the expected arguments', () => {
		registerBlocks( mockBlocksToRegister );

		expect( mockRegisterBlockType ).toHaveBeenNthCalledWith(
			1,
			firstName,
			firstSettings
		);

		expect( mockRegisterBlockType ).toHaveBeenNthCalledWith(
			2,
			secondName,
			secondSettings
		);
	} );
} );
