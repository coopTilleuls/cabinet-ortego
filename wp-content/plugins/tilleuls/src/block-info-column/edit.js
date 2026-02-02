import {RichText, useBlockProps} from '@wordpress/block-editor';
import {Button, SelectControl, Tooltip} from '@wordpress/components';
import {ICONS} from '../lib/icon';
import './editor.scss';

export default function Edit({attributes, setAttributes}) {
	const {infoItems = []} = attributes;

	const blockProps = useBlockProps({
		className: 'section-contact-details'
	});

	const addItem = () => {
		const newItems = [
			...infoItems,
			{
				icon: 'tag',
				title: 'Nouveau titre',
				content: 'Description...',
				highlight: ''
			}
		];
		setAttributes({infoItems: newItems});
	};

	const removeItem = (index) => {
		const newItems = infoItems.filter((_, i) => i !== index);
		setAttributes({infoItems: newItems});
	};

	const updateItem = (index, key, value) => {
		const newItems = [...infoItems];
		newItems[index] = {...newItems[index], [key]: value};
		setAttributes({infoItems: newItems});
	};

	return (
		<div {...blockProps}>
			{infoItems.map((item, index) => (
				<div className="info-card">
					<div key={index} className="info-item"
							 style={{display: 'flex', gap: '15px', marginBottom: '20px', position: 'relative'}}>
						<Tooltip text="Supprimer cet élément">
							<Button
								icon="trash"
								isDestructive
								isSmall
								onClick={() => removeItem(index)}
								style={{position: 'absolute', right: 0, top: 0, opacity: 0.5}}
							/>
						</Tooltip>
						<div style={{minWidth: '30px'}}>
							<i className={ICONS[item.icon]?.class || 'fa-solid fa-question'}
								 style={{color: '#8C1818', fontSize: '1.2rem', marginTop: '5px'}}></i>
							<SelectControl
								value={item.icon}
								options={Object.entries(ICONS).map(([k, v]) => ({label: v.label, value: k}))}
								onChange={(val) => updateItem(index, 'icon', val)}
								style={{fontSize: '10px', width: '100%', marginTop: '5px'}}
							/>
						</div>
						<div style={{flexGrow: 1}}>
							<RichText
								tagName="h4"
								value={item.title}
								onChange={(val) => updateItem(index, 'title', val)}
								placeholder="Titre (ex: Honoraires)"
								style={{fontSize: '1rem', fontWeight: '600', marginBottom: '5px', marginTop: 0, color: '#8C1818'}}
							/>
							<RichText
								tagName="p"
								className="price-highlight"
								value={item.highlight}
								onChange={(val) => updateItem(index, 'highlight', val)}
								placeholder="Mise en avant (ex: 80 € TTC)"
								style={{fontSize: '1.1rem', fontWeight: '700', color: '#1a1a1a', margin: '0 0 5px 0'}}
							/>
							<RichText
								tagName="p"
								value={item.content}
								onChange={(val) => updateItem(index, 'content', val)}
								placeholder="Détails..."
								style={{fontSize: '0.85rem', color: '#555', margin: 0}}
							/>
						</div>
					</div>
				</div>
			))}

			<Button isSecondary isSmall onClick={addItem} style={{width: '100%', marginTop: '10px'}}>
				+ Ajouter une information
			</Button>
		</div>
	);
}
