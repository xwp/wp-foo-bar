module.exports = {
  verbose: true,
  collectCoverageFrom: [
	"assets/src/**",
	"!**/polyfills/**"
  ],
  testPathIgnorePatterns: [
	"/bin/",
	"/build/",
    "/node_modules/",
	"/vendor/"
  ]
};
