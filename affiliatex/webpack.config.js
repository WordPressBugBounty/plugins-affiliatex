const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const fs = require('fs');

// Root path
const ROOT_PATH = path.resolve(__dirname);

// Path configurations
const PATHS = {
	free: {
		src: path.join(ROOT_PATH, 'src'),
		build: path.join(ROOT_PATH, 'build'),
		blocks: path.join(ROOT_PATH, 'src/blocks')
	},
	pro: {
		src: path.join(ROOT_PATH, 'pro/src'),
		build: path.join(ROOT_PATH, 'pro/build'),
		blocks: path.join(ROOT_PATH, 'pro/src/blocks/blocks')
	}
};

// Free version entries
const freeEntries = {
	blocks: path.join(PATHS.free.src, 'blocks/blocks.js'),
	adminJS: path.join(PATHS.free.src, 'admin/index.js'),
	noticesJS: path.join(PATHS.free.src, 'admin/notices.js'),
	dashboard: path.join(PATHS.free.src, 'admin/scss/dashboard.scss'),
	admin: path.join(PATHS.free.src, 'blocks/scss/index.scss'),
	editorCSS: path.join(PATHS.free.src, 'blocks/scss/editor.scss'),
	publicCSS: path.join(PATHS.free.src, 'blocks/scss/public.scss'),
	blockComponents: path.join(PATHS.free.src, 'blocks/blocks-export.js'),
	adminCSS: path.join(PATHS.free.src, 'admin/scss/index.scss'),
	proBlocksPreview: path.join(PATHS.free.src, 'blocks/pro-blocks-preview.js'),
};

// Free blocks
const freeBlocks = {
	'blocks/buttons/index': path.join(PATHS.free.blocks, 'buttons/index.js'),
	'blocks/cta/index': path.join(PATHS.free.blocks, 'cta/index.js'),
	'blocks/notice/index': path.join(PATHS.free.blocks, 'notice/index.js'),
	'blocks/product-comparison/index': path.join(PATHS.free.blocks, 'product-comparison/index.js'),
	'blocks/product-table/index': path.join(PATHS.free.blocks, 'product-table/index.js'),
	'blocks/pros-and-cons/index': path.join(PATHS.free.blocks, 'pros-and-cons/index.js'),
	'blocks/single-product/index': path.join(PATHS.free.blocks, 'single-product/index.js'),
	'blocks/specifications/index': path.join(PATHS.free.blocks, 'specifications/index.js'),
	'blocks/verdict/index': path.join(PATHS.free.blocks, 'verdict/index.js'),
	'blocks/versus-line/index': path.join(PATHS.free.blocks, 'versus-line/index.js'),
};

// Pro version entries
const proEntries = {
	blocks: path.join(PATHS.pro.src, 'blocks/blocks.js'),
	frontendJs: path.join(PATHS.pro.src, 'blocks/frontend.js'),
	adminJS: path.join(PATHS.pro.src, 'admin/index.js'),
	adminCSS: path.join(PATHS.pro.src, 'admin/scss/index.scss'),
	admin: path.join(PATHS.pro.src, 'blocks/scss/index.scss'),
	editor: path.join(PATHS.pro.src, 'blocks/scss/editor.scss'),
	public: path.join(PATHS.pro.src, 'blocks/scss/public.scss'),
	blockComponents: path.join(PATHS.free.src, 'blocks/blocks-export.js'),
};

// Pro blocks
const proBlocks = {
	'blocks/coupon-grid/index': path.join(PATHS.pro.blocks, 'coupon-grid/index.js'),
	'blocks/coupon-listing/index': path.join(PATHS.pro.blocks, 'coupon-listing/index.js'),
	'blocks/product-image-button/index': path.join(PATHS.pro.blocks, 'product-image-button/index.js'),
	'blocks/product-tabs/index': path.join(PATHS.pro.blocks, 'product-tabs/index.js'),
	'blocks/product-tabs-child/index': path.join(PATHS.pro.blocks, 'product-tabs-child/index.js'),
	'blocks/single-coupon/index': path.join(PATHS.pro.blocks, 'single-coupon/index.js'),
	'blocks/single-product-pros-and-cons/index': path.join(PATHS.pro.blocks, 'single-product-pros-and-cons/index.js'),
	'blocks/top-products/index': path.join(PATHS.pro.blocks, 'top-products/index.js'),
	'blocks/versus/index': path.join(PATHS.pro.blocks, 'versus/index.js'),
	'blocks/rating-box/index': path.join(PATHS.pro.blocks, 'rating-box/index.js'),
};

module.exports = (env = {}) => {
	const isPro = env.pro === true || env.pro === 'true';
	const isDevelopment = process.env.NODE_ENV !== 'production';
	console.log(`Building for: ${isPro ? 'PRO' : 'FREE'} in ${isDevelopment ? 'development' : 'production'} mode`);

	const entries = isPro ? { ...proEntries, ...proBlocks } : { ...freeEntries, ...freeBlocks };
	const buildPath = isPro ? PATHS.pro.build : PATHS.free.build;

	// Configuration
	const config = {
		...defaultConfig,
		entry: entries,
		output: {
			path: buildPath,
			filename: '[name].js',
			library: ["affiliatexExports", "[name]"],
			clean: true
		},
		externals: {
			...defaultConfig.externals,
			"affiliatex-components": "window.affiliatexExports.blockComponents",
		},
		// Cache optimization
		cache: {
			type: 'filesystem',
			allowCollectingMemory: true,
			buildDependencies: {
				config: [__filename],
			},
			compression: 'gzip',
			cacheDirectory: path.resolve(__dirname, 'node_modules/.cache/webpack'),
			name: isPro ? 'affiliatex-pro' : 'affiliatex-free',
			profile: true,
			maxAge: 172800000,
			maxMemoryGenerations: 5,
			memoryCacheUnaffected: true,
			store: 'pack',
			version: '1.0'
		}
	};

	// Pro-specific plugins
	if (isPro) {
		try {
			const proBlockDirectories = fs.readdirSync(PATHS.pro.blocks)
				.filter(file => fs.statSync(path.join(PATHS.pro.blocks, file)).isDirectory());

			const copyPatterns = proBlockDirectories.map(dir => ({
				from: path.join(PATHS.pro.blocks, `${dir}/block.json`),
				to: path.join(PATHS.pro.build, `blocks/${dir}/block.json`)
			}));

			config.plugins.push(new CopyWebpackPlugin({ patterns: copyPatterns }));
		} catch (error) {
			console.warn('Warning: Could not read pro blocks directory', error);
		}
	}

	// Build logger
	if (isDevelopment) {
		config.plugins.push({
			apply: (compiler) => {
				compiler.hooks.done.tap('BuildLogger', (stats) => {
					const assets = stats.toJson().assets;
					console.log('\nGenerated files:');
					assets.forEach(asset => {
						console.log(`- ${asset.name}`);
					});
				});
			}
		});
	}

	return config;
};
