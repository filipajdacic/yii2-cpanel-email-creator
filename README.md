cPanel Email Account Creator Extension
======================================
With this extension you will be able to easly programatically create cPanel email account from your yii2 application.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist filipajdacic/yii2-cpanel-email-creator "*"
```

or add

```
"filipajdacic/yii2-cpanel-email-creator": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  in config:
```php
'components' => array(
    ...
    'cpanelemailcreator' => array(
        'class' => 'filipajdacic\cpanelemailcreator\EmailCreator',
        'ip' => 'YOUR_CPANEL_SERVER/HOST_IP_ADDRESS',
        'port' => '2083', // it can be also 2086
        'cpanel_username' => 'YOUR_CPANEL_USERNAME',
        'cpanel_password' => 'YOUR_CPANEL_PASSWORD'
    ),
    ...
);
```

After you have configure component, you can use it in this way:
```php

$domain = "mywebsite.com";
$email_username = "john.doe";
$email_password = "myaccountpassword123!";
$email_quota = 500; // in MB

$create_mail_account_result = Yii::$app->cpanelemailcreator->createNewAccount(
	$domain, 
	$email_username, 
	$email_password, 
	$email_quota
);

if($create_mail_account_result) {
	$result =  "Mail account ".$email_username."@".$domain." is created.";
} else {
	$result =  "Mail account is not created. Reason:".$create_mail_account_result;
}

echo $result;

```

Note that password strong policy is defined in WHM (Web Host Manager).
If you have any questions, feel free to ask!