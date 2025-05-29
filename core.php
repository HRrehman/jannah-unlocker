// Remove license overlay and blur in admin
add_action('admin_head', function () {
    echo '<style>
        .tie-license-disable-section {
            display: none !important;
        }
        #tie-page-builder,
        #tie-page-builder-button {
            filter: none !important;
        }
    </style>';
});

// Bypass license and inject fake data
add_action('after_setup_theme', function () {
    if (!defined('TIELABS_THEME_ID')) return;

    update_option('tie_token_' . TIELABS_THEME_ID, 'valid-fake-token');
    delete_option('tie_token_error_' . TIELABS_THEME_ID);

    update_option('tie_theme_data_' . TIELABS_THEME_ID, [
        'status' => 1,
        'message' => 'Your license is validated.',
        'supported_until' => '2099-12-31',
        'username' => 'habib',
        'buyer' => 'client',
        'license' => 'Regular License',
        'item_id' => 19659555
    ]);
});

// Block external API calls to Tielabs
add_filter('http_request_args', function ($args, $url) {
    if (strpos($url, 'tielabs.com') !== false) {
        $args['timeout'] = 0.1;
        $args['body'] = [];
    }
    return $args;
}, 10, 2);

// Footer branding lock
add_action('admin_footer', function () {
    echo '<style>#footer-left::after { content: " | Powered by Habib ur Rehman"; color: #00aa00; }</style>';
});
