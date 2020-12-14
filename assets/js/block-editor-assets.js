wp.domReady( function() {

	// Remove button block styles
	wp.blocks.unregisterBlockStyle( 'core/button', 'default' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );

	// Register a custom block style variation
	wp.blocks.registerBlockStyle( 'core/button', {
    name: 'default',
    label: 'Default',
    isDefault: true
	});

	wp.blocks.registerBlockStyle( 'core/button', {
    name: 'full-width',
    label: 'Full Width',
    isDefault: false
	});

} );