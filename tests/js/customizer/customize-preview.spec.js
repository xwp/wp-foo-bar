import { multiply } from '../../../assets/src/customizer/customize-preview';

describe( 'demo: multiply', () => {
	it( 'should equal the product of two numbers', () => {
		expect( multiply( 2, 2 ) ).toStrictEqual( 4 );
	} );
} );
