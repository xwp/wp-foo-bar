import { add } from './editor';

describe( 'ensure setup works', () => {
	it( 'should be equal when evaluating two arrays', () => {
		expect( add( 1, 2 ) ).toStrictEqual( 3 );
	} );
} );
