module.exports = {
	verbose: true,
	collectCoverageFrom: [
		"assets/src/**",
		"!assets/src/polyfills/**"
	],
	testMatch: [
		"**/tests/**/*.[jt]s?(x)",
		"**/?(*.)+(spec|test).[jt]s?(x)"
	],
	testPathIgnorePatterns: [
		"bin/",
		"build/",
		"built/",
		"node_modules/",
		"vendor/"
	]
};
