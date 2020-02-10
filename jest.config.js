module.exports = {
	verbose: true,
	collectCoverageFrom: [
		"assets/src/**",
		"!assets/src/polyfills/**"
	],
	testPathIgnorePatterns: [
		"bin/",
		"build/",
		"built/",
		"node_modules/",
		"vendor/"
	]
};
