import { add } from '../../../assets/src/classic-editor/';

describe( 'demo: add', () => {
	it( 'should equal the sum of two numbers', () => {
		expect( add( 2, 2 ) ).toStrictEqual( 4 );
	} );
} );
