/**
 * Merge JS and e2e coverage reports.
 */

const fs = require( 'fs-extra' );
const istanbulReports = require( 'istanbul-reports' );
const libReport = require( 'istanbul-lib-report' );
const istanbulCoverage = require( 'istanbul-lib-coverage' );
const args = require( 'minimist' )( process.argv.slice( 2 ) );

/* [ Configuration ] */
const rootDir = 'tests/coverage';
const reportOut = 'tests/coverage/js-e2e';

const mergeAllReports = ( coverageMap, reports ) => {
	if ( Array.isArray( reports ) === false ) {
		return;
	}

	reports.forEach( reportFile => {
		const coverageReport = fs.readJSONSync( reportFile );
		coverageMap.merge( coverageReport );
	} );
};

const generateReport = ( coverageMap, type ) => {
	// create a context for report generation
	const context = libReport.createContext( {
		dir: reportOut,
		defaultSummarizer: 'nested',
		coverageMap,
	} );

	const reportType = Array.isArray( type ) ? type.pop() : type;

	// create an instance of the relevant report class
	const report = istanbulReports.create( reportType );

	// call execute to synchronously create and write the report to disk
	report.execute( context );

	// show the report text summary in console only if the reporter is not a text report.
	if ( ! reportType.includes( 'text' ) ) {
		const text = istanbulReports.create( 'text' );

		text.execute( context );
	}
};

async function main() {
	const coverageMap = istanbulCoverage.createCoverageMap( {} );

	const reports = [ rootDir + '/e2e/coverage-final.json' ];

	if ( false !== args.js ) {
		reports.push( rootDir + '/js/coverage-final.json' );
	}

	if ( Array.isArray( reports ) ) {
		mergeAllReports( coverageMap, reports );
		generateReport( coverageMap, args.reporter || 'lcov' );
	}
}

main().catch( err => {
	console.error( err ); // eslint-disable-line
	process.exit( 1 );
} );
