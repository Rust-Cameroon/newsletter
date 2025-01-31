<?php

return [
    'global' => [
        'title' => 'Global Settings',

        'elements' => [
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_logo', // unique name for field
                'label' => 'Site Logo', // you know what label it is
                'rules' => 'mimes:jpeg,jpg,png|max:1000', // validation rule of laravel
                'value' => 'default/fav.png', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_logo_height', // unique name for field
                'label' => 'Site Logo Height', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_logo_width', // unique name for field
                'label' => 'Site Logo Width', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_favicon', // unique name for field
                'label' => 'Site Favicon', // you know what label it is
                'rules' => 'mimes:jpeg,jpg,png|max:1000', // validation rule of laravel
                'value' => 'image/logo.png', // default value if you want
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'login_bg', // unique name for field
                'label' => 'Admin Login Cover', // you know what label it is
                'rules' => 'mimes:jpeg,jpg,png|max:2000', // validation rule of laravel
                'value' => 'default/auth-bg.jpg', // default value if you want
            ],

            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_admin_prefix', // unique name for field
                'label' => 'Site Admin Prefix', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'admin', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_title', // unique name for field
                'label' => 'Site Title', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'value' => 'Digi Bank', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'account_number_prefix', // unique name for field
                'label' => 'Account Number Prefix', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'DGB', // default value if you want
            ],
            // [
            //     'type' => 'switch', // input fields type
            //     'data' => 'string', // data type, string, int, boolean
            //     'name' => 'site_currency_type', // unique name for field
            //     'label' => 'Site Currency Type', // you know what label it is
            //     'rules' => 'required', // validation rule of laravel
            //     'value' => 'fiat', // default value if you want
            // ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_currency', // unique name for field
                'label' => 'Site Currency', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'USD', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'currency_symbol', // unique name for field
                'label' => 'Currency Symbol', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '$', // default value if you want
            ],
            [
                'type' => 'dropdown', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_timezone', // unique name for field
                'label' => 'Site Timezone', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'UTC', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'referral_code_limit', // unique name for field
                'label' => 'Referral Code Limit', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '6', // default value if you want
            ],
            [
                'type' => 'dropdown', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'home_redirect', // unique name for field
                'label' => 'Home Redirect', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '/', // default value if you want
            ],
            [
                'type' => 'email', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'site_email', // unique name for field
                'label' => 'Site Email', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'admin@tdevs.co', // default value if you want
            ],
            [
                'type' => 'email', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'support_email', // unique name for field
                'label' => 'Support Email', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'support@tdevs.co', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'referral_rules_visibility', // unique name for field
                'label' => 'Referral Rules Visibility', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '1', // default value if you want
            ],
        ],
    ],

    'permission' => [
        'title' => 'Permission Settings',
        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'multi_branch', // unique name for field
                'label' => 'Banking System', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'passcode_verification', // unique name for field
                'label' => 'Passcode', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'email_verification', // unique name for field
                'label' => 'Email Verification', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_verification', // unique name for field
                'label' => 'KYC Verification', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'fa_verification', // unique name for field
                'label' => '2FA Verification', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'otp_verification', // unique name for field
                'label' => 'OTP Verification', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'account_creation', // unique name for field
                'label' => 'Account Creation', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_deposit', // unique name for field
                'label' => 'User Deposit', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_dps', // unique name for field
                'label' => 'User DPS', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_fdr', // unique name for field
                'label' => 'User FDR', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_loan', // unique name for field
                'label' => 'User Loan', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_reward', // unique name for field
                'label' => 'User Reward', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_portfolio', // unique name for field
                'label' => 'User Portfolio', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_withdraw', // unique name for field
                'label' => 'User Withdraw', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'transfer_status', // unique name for field
                'label' => 'User Fund Transfer', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'user_pay_bill', // unique name for field
                'label' => 'User Pay Bill', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'sign_up_referral', // unique name for field
                'label' => 'User Referral', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'referral_signup_bonus', // unique name for field
                'label' => 'Signup Bonus', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'site_animation', // unique name for field
                'label' => 'Site Animation', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'back_to_top', // unique name for field
                'label' => 'Site Back to Top', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'language_switcher', // unique name for field
                'label' => 'Language Switcher', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 0, // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'default_mode', // unique name for field
                'label' => 'Default Mode', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'dark', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'debug_mode', // unique name for field
                'label' => 'Development Mode', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 0, // default value if you want
            ],
        ],
    ],

    'system' => [
        'title' => 'System Settings',
        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'session_lifetime', // unique name for field
                'label' => 'Session Lifetime', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '120', // default value if you want
            ]
        ]
    ],

    'fee' => [
        'title' => 'Site Bonus, Fee Settings',
        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'referral_bonus', // unique name for field
                'label' => 'Referral Bonus', // you know what label it is
                'rules' => 'required|regex:/^\d+(\.\d{1,2})?$/', // validation rule of laravel
                'value' => 20, // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'signup_bonus', // unique name for field
                'label' => 'Sign Up Bonus', // you know what label it is
                'rules' => 'required|regex:/^\d+(\.\d{1,2})?$/', // validation rule of laravel
                'value' => 20, // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'fund_transfer_charge', // unique name for field
                'label' => 'Fund Transfer Charge', // you know what label it is
                'rules' => 'required|regex:/^\d+(\.\d{1,2})?$/', // validation rule of laravel
                'value' => 4, // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'double', // data type, string, int, boolean
                'name' => 'fund_transfer_charge_type', // unique name for field
                'label' => 'Fund Transfer Charge Type', // you know what label it is
                'rules' => 'required|regex:/^\d+(\.\d{1,2})?$/', // validation rule of laravel
                'value' => 'percentage', // default value if you want
            ],
        ],
    ],
    'kyc' => [
        'title' => 'Feature Availability for KYC Unverified Users',
        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_deposit', // unique name for field
                'label' => 'Deposit', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],

            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_fund_transfer', // unique name for field
                'label' => 'Fund Transfer', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],

            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_dps', // unique name for field
                'label' => 'DPS', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],

            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_fdr', // unique name for field
                'label' => 'FDR', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],

            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_loan', // unique name for field
                'label' => 'Loan', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],

            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_pay_bill', // unique name for field
                'label' => 'Pay Bill', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],

            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'kyc_withdraw', // unique name for field
                'label' => 'Withdraw', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
        ],
    ],

    'passcode' => [
        'title' => 'Passcode Management',
        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'deposit_passcode_status', // unique name for field
                'label' => 'Deposit', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'fund_transfer_passcode_status', // unique name for field
                'label' => 'Fund Transfer', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'dps_passcode_status', // unique name for field
                'label' => 'DPS', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'fdr_passcode_status', // unique name for field
                'label' => 'FDR', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'loan_passcode_status', // unique name for field
                'label' => 'Loan', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'pay_bill_passcode_status', // unique name for field
                'label' => 'Pay Bill', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'withdraw_passcode_status', // unique name for field
                'label' => 'Withdraw', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0', // default value if you want
            ],
        ],
    ],

    // 'color' => [
    //     'title' => 'Color Management',
    //     'elements' => [
    //         [
    //             'type' => 'color',
    //             'data' => 'string',
    //             'name' => 'primary_color',
    //             'label' => 'Primary Color',
    //             'rules' => 'required',
    //             'value' => '#E73667',
    //         ],
    //         [
    //             'type' => 'color',
    //             'data' => 'string',
    //             'name' => 'secondary_color',
    //             'label' => 'Secondary Color',
    //             'rules' => 'required',
    //             'value' => '#AA44B9',
    //         ]
    //     ]
    // ],

    'inactive_user' => [
        'title' => 'Inactive User Setting',
        'elements' => [
            [
                'type' => 'switch',
                'data' => 'string',
                'name' => 'inactive_account_disabled',
                'label' => 'Inactive Account Disable',
                'rules' => 'required',
                'value' => '1',
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'inactive_days',
                'label' => 'Inactive Days',
                'rules' => 'required',
                'value' => '30',
            ],
            [
                'type' => 'switch',
                'data' => 'string',
                'name' => 'inactive_account_fees',
                'label' => 'Inactive Account Fees',
                'rules' => 'required',
                'value' => '1',
            ],
            [
                'type' => 'double',
                'data' => 'string',
                'name' => 'fee_amount',
                'label' => 'Fee Amount',
                'rules' => 'required',
                'value' => '5',
            ],
        ],
    ],

    'mail' => [
        'title' => 'Mail Settings',
        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'email_from_name', // unique name for field
                'label' => 'Email From Name', // you know what label it is
                'rules' => 'required|min:5|max:50', // validation rule of laravel
                'value' => 'Tdevs', // default value if you want
            ],
            [
                'type' => 'email', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'email_from_address', // unique name for field
                'label' => 'Email From Address', // you know what label it is
                'rules' => 'required|min:5|max:50', // validation rule of laravel
                'value' => 'wd2rasel@gmail.com', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'mailing_driver', // unique name for field
                'label' => 'Mailing Driver', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'SMTP', // default value if you want
            ],

            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'mail_username', // unique name for field
                'label' => 'Mail Username', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '465', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'mail_password', // unique name for field
                'label' => 'Mail Password', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '0000', // default value if you want
            ],

            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'mail_host', // unique name for field
                'label' => 'Mail Host', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'mail.tdevs.co', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'integer', // data type, string, int, boolean
                'name' => 'mail_port', // unique name for field
                'label' => 'Mail Port', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '465', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'mail_secure', // unique name for field
                'label' => 'Mail Secure', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'ssl', // default value if you want
            ],
        ],
    ],

    'site_maintenance' => [
        'title' => 'Site Maintenance',
        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'maintenance_mode', // unique name for field
                'label' => 'Maintenance Mode', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'secret_key', // unique name for field
                'label' => 'Secret Key', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'secret', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'maintenance_title', // unique name for field
                'label' => 'Title', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'Site is not under maintenance', // default value if you want
            ],
            [
                'type' => 'textarea', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'maintenance_text', // unique name for field
                'label' => 'Maintenance Text', // you know what label it is
                'rules' => 'required|max:500', // validation rule of laravel
                'value' => 'Sorry for interrupt! Site will live soon.', // default value if you want
            ],
        ],
    ],

    'gdpr' => [
        'title' => 'GDPR Settings',
        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'gdpr_status', // unique name for field
                'label' => 'GDPR Status', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 1, // default value if you want
            ],
            [
                'type' => 'textarea', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'gdpr_text', // unique name for field
                'label' => 'GDPR Text', // you know what label it is
                'rules' => 'required|max:500', // validation rule of laravel
                'value' => 'Please allow us to collect data about how you use our website. We will use it to improve our website, make your browsing experience and our business decisions better. Learn more', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'gdpr_button_label', // unique name for field
                'label' => 'Button Label', // you know what label it is
                'rules' => 'required|max:500', // validation rule of laravel
                'value' => 'Learn More', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'gdpr_button_url', // unique name for field
                'label' => 'Button URL', // you know what label it is
                'rules' => 'required|max:500', // validation rule of laravel
                'value' => '/privacy-policy', // default value if you want
            ],
        ],
    ],

    'meta' => [
        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'meta_description', // unique name for field
                'label' => 'Meta Description', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'Digi Bank is a fully online banking system.', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'meta_keywords', // unique name for field
                'label' => 'Meta Keywords', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'digibank,digital banking', // default value if you want
            ],
        ]
    ]

];
