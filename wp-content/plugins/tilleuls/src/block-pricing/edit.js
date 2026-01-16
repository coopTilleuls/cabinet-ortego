import {InnerBlocks, RichText, useBlockProps} from '@wordpress/block-editor';
import {Button, ToggleControl, Tooltip} from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { pricingCards = [] } = attributes;

	const blockProps = useBlockProps({
		className: 'section-pricing'
	});

	const addCard = () => {
		const newCards = [
			...pricingCards,
			{
				title: 'Titre du forfait',
				price: '0€',
				unit: '/ heure',
				features: ['Caractéristique 1', 'Caractéristique 2'],
				buttonText: 'Réserver',
				isFeatured: false,
				buttonStyle: 'primary'
			}
		];
		setAttributes({ pricingCards: newCards });
	};

	const removeCard = (index) => {
		const newCards = pricingCards.filter((_, i) => i !== index);
		setAttributes({ pricingCards: newCards });
	};

	const updateCard = (index, key, value) => {
		const newCards = [...pricingCards];
		newCards[index] = { ...newCards[index], [key]: value };
		setAttributes({ pricingCards: newCards });
	};

	const updateFeature = (cardIndex, featureIndex, value) => {
		const newCards = [...pricingCards];
		const newFeatures = [...newCards[cardIndex].features];
		newFeatures[featureIndex] = value;
		newCards[cardIndex].features = newFeatures;
		setAttributes({ pricingCards: newCards });
	};

	const addFeature = (cardIndex) => {
		const newCards = [...pricingCards];
		newCards[cardIndex].features = [...newCards[cardIndex].features, 'Nouvelle option'];
		setAttributes({ pricingCards: newCards });
	};

	const removeFeature = (cardIndex, featureIndex) => {
		const newCards = [...pricingCards];
		newCards[cardIndex].features = newCards[cardIndex].features.filter((_, i) => i !== featureIndex);
		setAttributes({ pricingCards: newCards });
	};

	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}],
	]

	return (
		<section {...blockProps}>
			<div className="container">
				<InnerBlocks
					template={INNER_BLOCKS}
				/>
				<div className="pricing-grid">
					{pricingCards.map((card, index) => (
						<div
							key={index}
							className={`price-card ${card.isFeatured ? 'featured' : ''}`}
							style={{
								position: 'relative',
							}}
						>
							<div className="card-controls" style={{ position: 'absolute', top: '-10px', right: '-10px', zIndex: 10, display: 'flex', gap: '5px' }}>
								<Tooltip text="Mettre en avant">
									<Button
										icon={card.isFeatured ? "star-filled" : "star-empty"}
										isSmall
										onClick={() => updateCard(index, 'isFeatured', !card.isFeatured)}
										style={{ background: card.isFeatured ? '#f0f0f0' : '#fff', border: '1px solid #ccc' }}
									/>
								</Tooltip>
								<Tooltip text="Supprimer la carte">
									<Button
										icon="trash"
										isDestructive
										isSmall
										onClick={() => removeCard(index)}
									/>
								</Tooltip>
							</div>
							<div className="price-header">
								<RichText
									tagName="h3"
									className="price-title"
									value={card.title}
									onChange={(val) => updateCard(index, 'title', val)}
									placeholder="Nom du forfait"
								/>
								<div className="price-amount">
									<RichText
										tagName="span"
										value={card.price}
										onChange={(val) => updateCard(index, 'price', val)}
										placeholder="80€"
										allowedFormats={[]}
									/>
									<RichText
										tagName="span"
										className="price-unit"
										value={card.unit}
										onChange={(val) => updateCard(index, 'unit', val)}
										placeholder="/ heure"
										style={{ fontSize: '0.9rem', color: '#555', fontWeight: 'normal' }}
									/>
								</div>
							</div>
							<div className="price-features">
								<ul>
									{card.features.map((feature, fIndex) => (
										<li key={fIndex}>
											<i className="fa-solid fa-check"></i>
											<RichText
												tagName="span"
												value={feature}
												onChange={(val) => updateFeature(index, fIndex, val)}
												placeholder="Caractéristique..."
												style={{ flexGrow: 1, fontSize: '0.9rem', color: '#555' }}
											/>
											<Button
												icon="no"
												isSmall
												onClick={() => removeFeature(index, fIndex)}
												style={{ opacity: 0.5 }}
											/>
										</li>
									))}
								</ul>
								<Button isSecondary isSmall onClick={() => addFeature(index)} style={{ width: '100%', marginBottom: '20px' }}>
									+ Ajouter une ligne
								</Button>
							</div>
							<div style={{ textAlign: 'center' }}>
								<RichText
									tagName="span"
									value={card.buttonText}
									onChange={(val) => updateCard(index, 'buttonText', val)}
									placeholder="Texte du bouton"
									className={`btn ${card.buttonStyle === 'primary' ? 'btn-primary' : 'btn-outline'}`}
									style={{
										display: 'inline-block',
										padding: '12px 30px',
										backgroundColor: card.buttonStyle === 'primary' ? '#8C1818' : 'transparent',
										color: card.buttonStyle === 'primary' ? '#fff' : '#1a1a1a',
										border: card.buttonStyle === 'primary' ? 'none' : '1px solid #1a1a1a',
										cursor: 'text'
									}}
								/>
								<div style={{ marginTop: '5px' }}>
									<ToggleControl
										label="Style Principal"
										checked={card.buttonStyle === 'primary'}
										onChange={() => updateCard(index, 'buttonStyle', card.buttonStyle === 'primary' ? 'outline' : 'primary')}
									/>
								</div>
							</div>
						</div>
					))}

					<div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', minHeight: '300px', border: '2px dashed #ccc', borderRadius: '4px' }}>
						<Button isSecondary onClick={addCard} icon="plus">
							Ajouter une carte Tarif
						</Button>
					</div>
				</div>
			</div>
		</section>
	);
}
