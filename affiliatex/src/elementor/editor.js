import React from 'react';
import ReactDOM from 'react-dom';
import UpgradeModal from '../blocks/ui-components/UpgradeModal';
import { __ } from '@wordpress/i18n';

(($) => {
    'use strict';

    const ElementorAmazonFree = {

        // Initialize the plugin.
        init() {
            if (window.AffiliateX && window.AffiliateX.proActive !== 'true') {
                ElementorAmazonFree.initUpgradeModal();
            }

            ElementorAmazonFree.bindEvents();
        },

        // Bind event listeners.
        bindEvents() {
            if(window.AffiliateX && window.AffiliateX.proActive !== 'true'){
                $(document).on('click', '.affx-action-button__amazon', ElementorAmazonFree.triggerUpgradeModal);
                $(document).on('click', '.affx-connect-all-wrapper', ElementorAmazonFree.triggerUpgradeModal);
            }
            
            $(window).on('elementor:init', ElementorAmazonFree.addConnectAllButton);

            // Ignore wp-auth-check.js error
            $(document).on('error', function (e) {
                if (e.originalEvent?.filename?.includes('wp-auth-check.js')) {
                    return false;
                }
            });
        },

        // Initialize upgrade modal.
        initUpgradeModal() {
            $('body').append('<div id="affx-upgrade-modal-root"></div>');

            const upgradeRootElement = document.getElementById('affx-upgrade-modal-root');

            if (upgradeRootElement && !upgradeRootElement.hasChildNodes()) {
                ReactDOM.createRoot(upgradeRootElement).render(<UpgradeModal />);
            }
        },
        
        // Trigger modal
        triggerUpgradeModal() {
            window.wp.data.dispatch('affiliatex').setActiveModal('upgrade-modal');
            window.wp.data.dispatch('affiliatex').setUpgradeModal({
                modalType: 'amazon',
                modalTitle: __("Amazon Integration", "affiliatex"),
                blockTitle: __("Amazon Integration", "affiliatex")
            });
        },

        // Handle the active widget.
        addConnectAllButton() {
            // List of widgets that don't need the connect all button.
            const excludeWidgets = [
                'affiliatex-product-comparison',
                'affiliatex-product-table',
                'affiliatex-pros-and-cons',
                'affiliatex-specifications',
                'affiliatex-verdict',
                'affiliatex-versus-line',
                'affiliatex-coupon-listing',
                'affiliatex-coupon-grid',
                'affiliatex-versus',
                'affiliatex-top-products',
            ];

            const addButton = (panel, model) => {
                if(panel && model){
                    if (
                        model?.get('widgetType') && 
                        model.get('widgetType').includes('affiliatex') && 
                        !excludeWidgets.includes(model.get('widgetType'))
                    ) {
                        if (panel.getOption('tab') === 'content') {
                            const navigationPanel = $(panel.el).find('.elementor-panel-navigation');
                            if($(panel.el).find('.affx-connect-all-wrapper').length === 0){
                                navigationPanel.after(AffiliateX.connectAllButton);
                            }
                        }
                    }
                }
            }

            // Triggers when a widget is activated.
            elementor.hooks.addAction('panel/open_editor/widget', addButton);
            
            const processedViews = new WeakSet();

            elementor.hooks.addFilter('controls/base/behaviors', (behaviors) => {
                const currentPageView = elementor.getPanelView().getCurrentPageView();
            
                // Only add button once per unique PageView
                if (currentPageView && !processedViews.has(currentPageView)) {
                    processedViews.add(currentPageView);
                    addButton(currentPageView, currentPageView.model);
                }
            
                return behaviors;
            });
        },
    };

    ElementorAmazonFree.init();
})(jQuery);