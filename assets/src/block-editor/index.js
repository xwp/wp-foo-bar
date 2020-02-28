// On running npm run dev, this will compile to assets/js/.

/**
 * Internal dependencies
 */
import { registerBlocks } from './helpers';

const blocksToRegister = require.context( './blocks', true, /(?<!test\/)index\.js$/ );
registerBlocks( blocksToRegister );
