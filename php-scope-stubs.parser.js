/* eslint-env node */
const fs = require( 'fs' );
const phpParserEngine = require( 'php-parser' );

const DESIRED_TOKENS = new Set( [ 'class', 'interface', 'function', 'trait' ] );

/**
 * Code Parser Factory.
 *
 * @return {phpParserEngine.Engine} new instance of a code parser.
 */
const createParser = () => {
	return phpParserEngine.create( {
		parser: {
			extractDoc: false,
		},
		ast: {
			withSource: false,
			withPositions: false,
		},
	} );
};

/**
 * Finds desired token within the parsed AST.
 *
 * @param {phpParserEngine.Program} parsed The parsed list of stubs.
 * @param {Function | null} filter Optional. The filter Callback.
 *
 * @return {string[]} The list of allowed tokens name with their namespaces.
 */
function findTokensName( parsed, filter = null ) {
	const found = [];

	const filterCb =
		filter ||
		function ( { kind } ) {
			return DESIRED_TOKENS.has( kind );
		};

	const { children: entities = [], errors = [] } = parsed || {};

	if ( ! entities.length ) {
		return found;
	}

	if ( errors.length ) {
		// eslint-disable-next-line no-console
		errors.forEach( ( { message } ) => console.error( message ) );
	}

	return entities.reduce( ( allFoundTokens, token ) => {
		let { children: targets = [], name: namespace, kind } = token;

		// The token itself is a target.
		if ( kind !== 'namespace' ) {
			targets = [ token ];
			namespace = '';
		}

		const tokens = targets
			.filter( entity => filterCb( entity ) )
			.map( ( { name: { name } } ) => {
				const tokenName = `${ namespace }\\${ name }`;

				// Remove the global namespace "\"  e.g. "\WP_Upgrade_Skin" -> "WP_Upgrade_Skin"
				return tokenName.replace( /^\\{1,2}/, '' );
			} );

		return [ ...tokens, ...allFoundTokens ];
	}, found );
}

/**
 * Extracts the global php stubs from the files.
 *
 * @param {string[]} filesPath The path to stubs file.
 *
 * @return {string[]} The list of global tokens name.
 */
const extractPhpTokenNames = ( filesPath = [] ) => {
	const parser = createParser();

	// The List of Classes/Interfaces/Traits/Functions.
	const foundUniqueTokens = filesPath.reduce(
		( tokensCollection, filePath ) => {
			const parsed = parser.parseCode(
				fs.readFileSync( filePath, { encoding: 'UTF-8' } )
			);
			// Using Set in order to have a unique tokens.
			return new Set( [ ...tokensCollection, ...findTokensName( parsed ) ] );
		},
		new Set()
	);

	return Array.from( foundUniqueTokens );
};

/**
 * Extracts the global php stubs from the files.
 *
 * @param {string[]} filesPath The path to stubs file.
 *
 * @return {Promise<string[]>} The list of global tokens name.
 */
const extractPhpTokenNamesAsync = async ( filesPath = [] ) => {
	const parser = createParser();

	const foundTokens = Promise.all(
		filesPath.map( filePath => {
			return new Promise( ( resolve, reject ) => {
				fs.readFile( filePath, { encoding: 'UTF-8' }, ( err, data ) => {
					if ( err ) {
						return reject( err );
					}
					// The List of Classes/Interfaces/Traits/Functions.
					return resolve( findTokensName( parser.parseCode( data ) ) );
				} );
			} );
		} )
	);

	const foundUniqueTokens = ( await foundTokens ).reduce(
		( tokensCollection, parsed ) => {
			// Using Set in order to have a unique tokens.
			return new Set( [ ...tokensCollection, ...parsed ] );
		},
		new Set()
	);

	return Array.from( foundUniqueTokens );
};

const gruntTaskResolver = function ( grunt ) {
	if ( ! this.files || ! grunt ) {
		throw new Error( 'Grunt context was not provided.' );
	}

	// We need to store all tokens into one file, so taking the first one.
	const [ stubsDistFile ] = this.files.map( ( { dist } ) => dist );

	if ( ! stubsDistFile ) {
		grunt.log.error( `"stubsDistFile" was not provided.` );

		grunt.log.warn(
			`The "stubsDistFile" is missed, the destination to the file where to store the global stubs.`
		);

		return false;
	}

	// Delete already existed file.
	if (
		grunt.file.exists( stubsDistFile ) &&
		grunt.file.isFile( stubsDistFile )
	) {
		grunt.file.delete( stubsDistFile );
	}

	const stubsFiles = this.files
		.map( ( { src: [ src ] } ) => src )
		.filter( Boolean );

	const { async: isAsync = true } = this.data;

	grunt.log.warn( `Found ${ stubsFiles.length } files.` );

	if ( isAsync ) {
		const scanFilesDone = this.async();

		extractPhpTokenNamesAsync( stubsFiles )
			.then( stubsTokens => {
				grunt.log.warn( `Found ${ stubsTokens.length } tokens` );
				grunt.file.write( stubsDistFile, JSON.stringify( stubsTokens ) );
			} )
			.finally( () => {
				scanFilesDone();
			} );
	} else {
		const stubsTokens = extractPhpTokenNames( stubsFiles );
		grunt.log.warn( `Found ${ stubsTokens.length } tokens` );
		grunt.file.write( stubsDistFile, JSON.stringify( stubsTokens ) );
	}

	return true;
};

module.exports = {
	gruntTaskResolver,
};
