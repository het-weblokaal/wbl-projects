// WordPress dependencies
const { registerBlockType } = wp.blocks;

// External dependancies
const { merge } = lodash;

// Imports
import metadata from './block.json';
import edit from './edit';
import save from './save';

// Get name from metadata
const { name } = metadata;

// Merge the metadata with the edit and save functions
const settings = merge(metadata, {
	edit: edit,
	save: save
});

// Register
registerBlockType( name, settings );