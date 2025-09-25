(function($) {
    'use strict';

    /**
     * AffiliateX Frontend Scripts Handler
     */
    const AffiliateXFrontend = {
        init() {
            AffiliateXFrontend.initHooks();
        },

        initHooks() {
            AffiliateXFrontend.handleBlockClick();
        },

        /**
         * Handle when full block link is enabled and user clicks on the block.
         */
        handleBlockClick() {
            $('[data-clickable="true"]').on('click', (event) => {
                if ( $(event.target).closest('.affiliatex-button').length > 0 || $(event.target).closest('.affiliatex-link').length > 0 ) {
                    return;
                }

                event.preventDefault();
                const block = $(event.currentTarget);
                const clickUrl = block.data('click-url');
                const clickNewTab = block.data('click-new-tab');
                window.open(clickUrl, clickNewTab ? '_blank' : '_self');
            });
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        AffiliateXFrontend.init();
    });

})(jQuery);
