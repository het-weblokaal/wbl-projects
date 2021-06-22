WBL Projects
===

# Developers

This plugin provides several filters to manipulate its behaviour:

- `add_filter( 'wbl/projects/block',                     <function>, 10, 2 );`
- `add_filter( 'wbl/projects/post_type/archive_slug',    <function>  );`
- `add_filter( 'wbl/projects/post_type/single_slug',     <function>  );`
- `add_filter( 'wbl/projects/post_type/labels',          <function>  );`
- `add_filter( 'wbl/projects/post_type/admin_columns',   <function>  );`
- `add_filter( 'wbl/projects/post_type/feature_support', <function>  );`
- `add_filter( 'wbl/projects/taxonomy/category/labels',  <function>  );`

## Note

For registering the post type and the taxonomies we use [the Extended CPTs library](https://github.com/johnbillion/extended-cpts) by John Blackbourn. This library provides several filters and actions. 

We don't officially support these filters as we might drop this library in the future.




