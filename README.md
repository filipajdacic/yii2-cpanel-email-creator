cPanel Email Account Creator Extension
======================================
With this extension you will be able to easly programatically create,update,delete cPanel email accounts from your yii2 application.

**With this component you are able to:**

-   Create new mail accounts

-   Change existing account disk quota

-   Change existing accounts their passwords

-   Delet accounts

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

After you have configured a component, you can use it in this way:

**1. Create a new mail account:**

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

**2. Change existing email account password:**

```php

$domain = "mywebsite.com";
$email_username = "john.doe";
$email_new_password = "mynewaccountpassword123$";


$change_password_result = 	Yii::$app->cpanelemailcreator->changeAccountPassword( 
										$domain, 
							            $email_username, 
							            $email_new_password
							);

if($change_password_result) {
	$result = "Mail account password for ".$email_username." is changed.";
} else {
	$result = "Password is not changed. Reason:".$change_password_result;
}

echo $result;
```

**3. Change existing email account disk quota:**

```php

$domain = "mywebsite.com";
$email_username = "john.doe";
$email_new_quota = "10000"; // in MB

$change_mail_quota_result = 	Yii::$app->cpanelemailcreator->changeEmailQuota( 
										$domain, 
							            $email_username, 
							            $email_new_quota
								);

if($change_mail_quota_result) {
	$result = "Mail quota for ".$email_username." is changed to ".$email_new_quota." MB.";
} else {
	$result = "Mail quota is not changed. Reason:".$change_password_result;
}

echo $result;

```

**4. Deleting existing email account**

```php

$domain = "mywebsite.com";
$email_username = "john.doe";

$delete_mail_result = 	Yii::$app->cpanelemailcreator->deleteMailAccount( 
										$domain, 
							            $email_username, 
							            $email_new_quota
						);

if($delete_mail_result) {
	$result = "Mail account ".$email_username."@".$domain." is deleted."; 
} else {
	$result = "Mail account is not deleted. Reason:".$change_password_result;
}

echo $result;

```


If you have any questions, feel free to ask!