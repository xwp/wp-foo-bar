import { subtract } from '../../../assets/src/customizer/customize-controls';

describe( 'demo: subtract', () => {
	it( 'should equal the difference of two numbers', () => {
		expect( subtract( 2, 2 ) ).toStrictEqual( 0 );
	} );
} );
