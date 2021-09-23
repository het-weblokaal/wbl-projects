
/**
 * WordPress dependencies
 */
const {	InspectorControls } = wp.blockEditor;
const {	PanelBody, RangeControl } = wp.components;
const { __ } = wp.i18n;

/**
 * Internal dependencies
 */

/**
 * Edit Settings function
 */
const EditSettings = ( { setAttributes, postsToShow } ) => (
	<InspectorControls>
		<PanelBody>
    		<RangeControl
				label={ __( 'Number of projects', 'wbl-projects' ) }
				value={ postsToShow }
				onChange={ ( newValue ) =>	setAttributes( { postsToShow: newValue } )	}
				min={ 1 }
				max={ 12 }
				required
			/>
		</PanelBody>
	</InspectorControls>
);

export default EditSettings;


