import { InnerBlocks } from '@wordpress/block-editor';

export default function save() {
	return (
		<div className="associations-banner">
			<div className="container associations-flex">
				<InnerBlocks.Content />
			</div>
		</div>
	);
}
