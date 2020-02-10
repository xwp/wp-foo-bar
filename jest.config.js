module.exports = {
	verbose: true,
	collectCoverageFrom: [
		"assets/src/**/*.js",
		"!assets/src/polyfills/**"
	],
	testPathIgnorePatterns: [
		"/node_modules/",
		"/vendor/",
		"/bin/"
	]
};
