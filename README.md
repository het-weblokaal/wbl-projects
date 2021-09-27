WBL Projects
===

# For developers

This plugin provides several filters to manipulate its behaviour:

- `add_filter( 'wbl/projects/post_type/archive_slug',    <function> )`;
- `add_filter( 'wbl/projects/post_type/single_slug',     <function> )`;
- `add_filter( 'wbl/projects/post_type/labels',          <function> )`;
- `add_filter( 'wbl/projects/post_type/admin_columns',   <function> )`;
- `add_filter( 'wbl/projects/post_type/feature_support', <function> )`;
- `add_filter( 'wbl/projects/taxonomy/category,          <function> )`;
- `add_filter( 'wbl/projects/taxonomy/category/labels',  <function> )`;
- `add_filter( 'wbl/projects/taxonomy/category/slug',    <function> )`;
- `add_filter( 'wbl/projects/block/projects',            <function>, 10, 2 ) `;
- `add_filter( 'wbl/projects/block/projects/render',     <function> )`;

## Usage of Extended CPTs library

For registering the post type and the taxonomies we use [the Extended CPTs library](https://github.com/johnbillion/extended-cpts) by John Blackbourn. This library provides several filters and actions. 

We don't officially support these filters as we might drop this library in the future.

## Permalinks

We want to create this permalink structure:

- project archive: `/projects/`
- singular: 	   `/projects/<project>`
- taxonomy: 	   `/projects/<taxonomy>/<term>`

For the taxonomy permalink to work we need to register the taxonomy before we register the post type. Source: https://cnpagency.com/blog/the-right-way-to-do-wordpress-custom-taxonomy-rewrites/.

