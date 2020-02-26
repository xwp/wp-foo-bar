module.exports = {
	rootDir: '../../',
	...require( '@wordpress/scripts/config/jest-e2e.config' ),
	transform: {
		'^.+\\.[jt]sx?$':
			'<rootDir>/node_modules/@wordpress/scripts/config/babel-transform',
	},
	transformIgnorePatterns: [ 'node_modules' ],
	setupFilesAfterEnv: [
		'<rootDir>/tests/e2e/config/bootstrap.js',
		'@wordpress/jest-puppeteer-axe',
		'expect-puppeteer',
	],
	testPathIgnorePatterns: [
		'<rootDir>/.git',
		'<rootDir>/node_modules',
		'<rootDir>/bin',
		'<rootDir>/build',
		'<rootDir>/tests/coverage',
	],
	coveragePathIgnorePatterns: [
		'<rootDir>/node_modules',
		'<rootDir>/build/',
		'<rootDir>/bin',
		'<rootDir>/tests/coverage',
	],
	collectCoverageFrom: [
		'<rootDir>/assets/src/**/*.js',
		'!<rootDir>/assets/src/polyfills/**',
	],
	reporters: [ [ 'jest-silent-reporter', { useDots: true } ] ],
};
