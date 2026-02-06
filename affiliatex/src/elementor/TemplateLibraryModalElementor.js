import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import TemplateLibraryModalBase from '../blocks/ui-components/TemplateLibraryModalBase';

const TemplateLibraryModalElementor = () => {
	const [ isOpen, setIsOpen ] = useState( false );
	const [ selectedWidget, setSelectedWidget ] = useState( '' );
	const [ editingWidget, setEditingWidget ] = useState( null );
	const [ editingWidgetType, setEditingWidgetType ] = useState( null );
	const [ affxWidgets, setAffxWidgets ] = useState( [] );

	const isPremium = window.AffiliateX && window.AffiliateX.proActive === 'true';

	// Get AffiliateX widgets from Elementor
	const getAffiliateXWidgets = () => {
		if ( ! window.elementor || ! window.elementor.widgetsCache ) {
			return [];
		}

		const widgets = [];
		for ( const [ key, widget ] of Object.entries( window.elementor.widgetsCache ) ) {
			if ( key.startsWith( 'affiliatex-' ) ) {
				widgets.push( {
					name: key,
					title: widget.title || key,
					icon: widget.icon || 'eicon-plug'
				} );
			}
		}

		return widgets;
	};

	// Initialize widgets including Pro blocks
	useEffect( () => {
		let allWidgets = getAffiliateXWidgets();

		// Add Pro widgets in free version
		if ( ! isPremium && window.proBlocks ) {
			const proWidgets = window.proBlocks.map( ( block ) => {
				// Convert block name to widget name (affiliatex/coupon-grid -> affiliatex-coupon-grid)
				const widgetName = block.name.replace( 'affiliatex/', 'affiliatex-' );
				return {
					name: widgetName,
					title: block.title,
					icon: 'eicon-plug',
					isPro: true
				};
			} );
			allWidgets = [ ...allWidgets, ...proWidgets ];
		}

		setAffxWidgets( allWidgets );
	}, [ isPremium ] );

	useEffect( () => {
		// Expose functions globally
		window.AffiliateXElementorTemplateLibrary = {
			open: ( widgetType, widgetModel ) => {
				if ( widgetType ) {
					setSelectedWidget( widgetType );
					if ( widgetModel ) {
						setEditingWidgetType( widgetType );
					}
				}
				if ( widgetModel ) {
					setEditingWidget( widgetModel );
				}
				setIsOpen( true );
			},
			close: () => {
				setIsOpen( false );
				setEditingWidget( null );
				setEditingWidgetType( null );
			}
		};
	}, [] );

	const insertTemplate = ( template ) => {
		const widgetData = {
			id: generateUniqueId(),
			elType: 'widget',
			widgetType: `affiliatex-${ selectedWidget || getWidgetTypeFromTemplate( template ) }`,
			settings: template.settings || {},
			elements: template.elements || []
		};

		insertElementorWidget( widgetData );
	};

	const focusWidget = ( widgetContainer ) => {
		if ( ! widgetContainer || ! widgetContainer.view ) {
			return;
		}

		const waitForView = () => {
			if ( widgetContainer.view.$el && widgetContainer.view.$el[ 0 ] ) {
				widgetContainer.view.$el[ 0 ].scrollIntoView( {
					behavior: 'smooth',
					block: 'center',
					inline: 'nearest'
				} );

				setTimeout( () => {
					widgetContainer.view.model.trigger( 'request:edit' );
				}, 100 );
			} else {
				requestAnimationFrame( waitForView );
			}
		};

		requestAnimationFrame( waitForView );
	};

	const replaceTemplate = ( template ) => {
		if ( ! editingWidget ) {
			return;
		}

		const elementId = editingWidget.get( 'id' );
		const container = elementor.getContainer( elementId );

		if ( ! container ) {
			return;
		}

		const widgetType = editingWidget.get( 'widgetType' );
		const parent = container.parent;
		const index = container.view._index;

		const newWidgetData = {
			elType: 'widget',
			widgetType,
			settings: template.settings || {}
		};

		// Delete old widget and create new one
		$e.run( 'document/elements/delete', { container } );
		$e.run( 'document/elements/create', {
			container: parent,
			model: newWidgetData,
			options: { at: index }
		} );

		// Wait for the widget to be created in the DOM
		const waitForWidget = () => {
			const newWidget = parent.children[ index ];
			if ( newWidget ) {
				focusWidget( newWidget );
			} else {
				// If widget not ready, try again on next frame
				requestAnimationFrame( waitForWidget );
			}
		};

		requestAnimationFrame( waitForWidget );

		setEditingWidget( null );
		setEditingWidgetType( null );
	};

	const generateUniqueId = () => {
		return Math.random().toString( 36 ).substr( 2, 8 );
	};

	const getWidgetTypeFromTemplate = () => {
		return 'single-product'; // Default fallback
	};

	const insertElementorWidget = ( widgetData ) => {
		if ( ! window.elementor || ! window.$e ) {
			return;
		}

		const sectionData = {
			elType: 'section',
			elements: [
				{
					elType: 'column',
					elements: [ widgetData ]
				}
			]
		};

		const documentContainer = elementor.documents.getCurrent().container;
		const sectionIndex = documentContainer.children.length;

		$e.run( 'document/elements/create', {
			model: sectionData,
			container: documentContainer,
			options: { at: sectionIndex }
		} );

		// Wait for the widget to be created in the DOM
		const waitForWidget = () => {
			const newSection = documentContainer.children[ sectionIndex ];
			const column = newSection?.children?.[ 0 ];
			const widget = column?.children?.[ 0 ];

			if ( widget ) {
				focusWidget( widget );
			} else {
				requestAnimationFrame( waitForWidget );
			}
		};

		requestAnimationFrame( waitForWidget );
	};

	const handleClose = () => {
		setIsOpen( false );
		setEditingWidget( null );
		setEditingWidgetType( null );
	};

	const canReplace = () => {
		return editingWidget && editingWidgetType && selectedWidget === editingWidgetType;
	};

	return (
		<TemplateLibraryModalBase
			isOpen={ isOpen }
			onClose={ handleClose }
			widgets={ affxWidgets }
			selectedWidget={ selectedWidget }
			onWidgetSelect={ setSelectedWidget }
			ajaxAction="get_elementor_template_library"
			ajaxNonce={ window.AffiliateX?.ajax_nonce || '' }
			onInsertTemplate={ insertTemplate }
			onReplaceTemplate={ replaceTemplate }
			canReplace={ canReplace() }
			editorType="elementor"
		/>
	);
};

export const initElementorTemplateLibrary = () => {
	let modalRoot = document.getElementById( 'affx-elementor-template-library-root' );

	if ( ! modalRoot ) {
		modalRoot = document.createElement( 'div' );
		modalRoot.id = 'affx-elementor-template-library-root';
		document.body.appendChild( modalRoot );
	}

	ReactDOM.createRoot( modalRoot ).render( <TemplateLibraryModalElementor /> );
};

export default TemplateLibraryModalElementor;
