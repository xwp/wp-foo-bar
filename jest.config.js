module.exports = {
  verbose: true,
  collectCoverageFrom: [
	"assets/js/admin.js",
	"assets/src/*.js"
  ],
  testPathIgnorePatterns: [
	"/node_modules/",
	"/vendor/",
	"/bin/"
  ]
};
