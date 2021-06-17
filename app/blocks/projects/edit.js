/**
 * WordPress dependencies
 */
const {	useBlockProps } = wp.blockEditor;
const { __ } = wp.i18n;
// const { withSelect } = wp.data;

/**
 * Internal dependencies
 */
// import { name } from './';
import EditSettings from './edit-settings';


/**
 * Edit function
 */
function edit( { attributes, setAttributes, isSelected } ) {

	// Get and setup attributes
	const postsToShow    = attributes.postsToShow;

	// Setup new variables
	const baseClassName      = "wbl-projects";
	const blockClassName     = baseClassName;

	// Setup blockProps
	const blockProps = useBlockProps( {
		className: blockClassName
	} );

	return (
		<>
			<div {...blockProps }>
	        	<div className={ `${baseClassName}__inner` }>
		            <h2 className={ `${blockClassName}__title` }>{ __('Projects', 'wbl-projects' ) }</h2>
		            <p className={ `${blockClassName}__text` }>{ __('This block will dynamically generate a number of projects. Check the frontend of your website.', 'wbl-projects' ) }</p>
				</div>
			</div>
			<EditSettings
				setAttributes={ setAttributes }
				postsToShow={ postsToShow }
			/>
		</>
	);
}

export default edit;
