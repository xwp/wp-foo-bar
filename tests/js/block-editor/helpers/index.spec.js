/**
 * Internal dependencies
 */
import { registerBlocks } from '../../../../assets/src/block-editor/helpers';

const mockRegisterBlockType = jest.fn();
jest.mock( '@wordpress/blocks', () => {
	return {
		registerBlockType: ( ...args ) => mockRegisterBlockType( ...args ),
	};
} );

const data = {
	biz: {
		name: 'foo-bar/biz',
		settings: {
			title: 'Biz',
		},
	},
	baz: {
		name: 'foo-bar/baz',
		settings: {
			title: 'Baz',
		},
	},
};

const mockBlocks = {
	'./blocks/biz/index.js': {
		...data.biz,
	},
	'./blocks/baz/index.js': {
		...data.baz,
	},
};

// Mocks the return value of the require.context() Webpack function.
const mockBlocksToRegister = modulePath => {
	return mockBlocks[ modulePath ];
};

mockBlocksToRegister.keys = () => {
	return Object.keys( mockBlocks );
};

describe( 'helpers: registerBlocks', () => {
	it( 'should register all of the expected blocks, with the expected arguments', () => {
		registerBlocks( mockBlocksToRegister );

		expect( mockRegisterBlockType ).toHaveBeenNthCalledWith(
			1,
			data.biz.name,
			data.biz.settings
		);

		expect( mockRegisterBlockType ).toHaveBeenNthCalledWith(
			2,
			data.baz.name,
			data.baz.settings
		);
	} );
} );
