# XKCD COMIC EMAIL SUBSCRIBER

This is a php based web application that sends a copy of xkcd comic to every subscriber in a fixed interval of time. It was developed for a PHP programming challenge as a part of [rtCamp's Campus hiring](https://learn.rtcamp.com/campus/).

#### DEMO: https://xkcd-subscriber.000webhostapp.com


 A short description of all the file in repo is as follows:
### 1. Config.php
It has all the configurations related to server and database like database name, server , database user-password.
### 2. Index.php
Welcome page of the application responsible for Sending verification mails to new users. Users can also resend requests if they have not verified their account. It creates a hashcode and sends it to the user in the form of a link.
### 3. Verify.php
When a user clicks the verification link the hashcode in the link is used to authenticate and activate the user's account.
### 4. Unsubs.php
This file helps users to unsubscribe to mail service and live life in peace without comics every 5 minutes in email. Same Hashcode authentication method is used where it used to identify users and deactivate their account.
### 5. Sendcomic.php
It takes in account all the subscribed users at the moment and scraps a comic page from XKCD and attaches it to email and sends them one by one. This file is called by cron service provided by the host at fixed intervals.
### 6. Users.sql
It contains the database structure used. MySQL database is used while development and hosting process.


## How to host your own starter pack!
1. To host this application on your own server, clone the repository, use some apache and prepare the database according to 'users.sql' (prefer MySQL).
2. Add your database configuration to the 'config.php' file.
3. Replace Google account in 'index.php' and 'sendcomic.php' and enable
4. Setup your cron to hit sendcomic.php and desired interval.


## ⚠️ Important Guidelines ⚠️
Emails recieved may be concidered spam since site is hosted on [000webhostapp](https://www.000webhost.com). Your mail service provider may concider all emails coming from 000webhost as spams. Also, mention rdns domain may not match domain in 'from' section of email in "index.php" & "sendcomic.php" which results in spam. Paid hosting can be used for the same to overcome this.

Google's SMTP port (TLS): 587 is used for mailing handled by [PHPMailer](https://github.com/PHPMailer/PHPMailer), a non-used gmail account is also attached with the code for sending emails.


## Screenshots
Some snippets of the project in action.

![index.php homepage to subscribe](https://i.ibb.co/njhFpDW/git1.jpg)
![verification link sent succesfully](https://i.ibb.co/PZVRm6c/git2.jpg)
![Verification link recieved](https://i.ibb.co/ZM9cxwX/git3.jpg)
![Acoount Verified Success](https://i.ibb.co/f2gWFwr/git4.jpg)
![Enjoy comic every 10 minute](https://i.ibb.co/ScssQjn/git4.jpg)
![Unsubscribed successfully](https://i.ibb.co/2vfGc1Y/git3.jpg)


