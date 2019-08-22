<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
	'on beforeAction' => function($event){
		$sso = new \akesandiego\sso\Component([
            'event'=>$event,
            'intranetCookieName' => 'dilg_intranet', //  Session Cookie name of the DILG Intranet / SSO
            'intranetTokenName' => 'intranet_token', // Name of the intranet cookie
            'authURL' => 'https://intranet.dilg.gov.ph/user/login', // URL of the Intranet / SSO
            'authAPIUrl' => 'https://intranet.dilg.gov.ph/user-management/user/access-list', // URL of the API
            'authLogoutUrl' => 'https://intranet.dilg.gov.ph/user-management/user/logout', // URL of logout function of the Intranet
            'authRegisterUrl' => 'https://intranet.dilg.gov.ph/user/register', // URL of registration function of the Intranet
            'appCode' => 'gad-admin', // abbreviation of this application's name
            'publicRegistration' => false, // default is false. set to true if the app will be used by non dilg users. user administration for public will be on the app's user module. 
            'prefix' => 'dilg_@' // username prefix to be used so that registrations on the application and users from intranet do not mix. 
		]);		
	}
];
