<?php
/**
 * Hello World block
 *
 * @package RWC Base
 * @author  Road Warrior Creative
 * @license GPL-2.0-or-later
 * @link    https://roadwarriorcreative.com/
**/

// get image fields
$title = get_field( 'title' );
$text = get_field( 'text' );

// create id attribute for specific styling
$id = 'hello-world-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<div id="<?php echo $id; ?>" class="hello-world-block <?php echo $align_class; ?>">
	<?php if( !empty( $title ) )
		echo '<h2>' . $title . '</h2>';
	if( !empty( $text ) )
		echo '<p>' . $text . '</p>';
	?>
</div>