<?php
	/***
 	*    ___  ___      _ _   _____              __ _       
 	*    |  \/  |     (_) | /  __ \            / _(_)      
 	*    | .  . | __ _ _| | | /  \/ ___  _ __ | |_ _  __ _ 
 	*    | |\/| |/ _` | | | | |    / _ \| '_ \|  _| |/ _` |
 	*    | |  | | (_| | | | | \__/\ (_) | | | | | | | (_| |
 	*    \_|  |_/\__,_|_|_|  \____/\___/|_| |_|_| |_|\__, |
 	*                                                 __/ |
 	*                                                |___/ 
 	* Configuration for sending mail to the users, we will be using a freely provided gmail account by default, so this shouldn't have to change much
 	*/
 	$email_domains = array( 'nku.edu' => 'NKU', 'mymail.nku.edu' => 'NKU' );
 	$email_list = array_keys($email_domains); //list of valid email domains, make sure to include the proceeding @ or this can be duped

 	date_default_timezone_set('Etc/UTC'); //set timezone for your emails to use
 	$smtp_server = "dmzemail.nku.edu"; //hostname of the mail server we will be sending the mail from
 	$smtp_port = 25; //port to make the smtp connection on, default is 25
 	$smtp_use_auth = true; //leave true eunless your mail server allows mail to be sent anonymously
 	$smtp_secure ="tls"; //set to tls if your server uses ssl, otherwise set to NULL without quotes
 	$mail_username='ivote@nku.edu'; //username for mail authther
 	$mail_password='nkunku12'; //pasword for mail auth
 	$mail_from_addr='ivote@nku.edu'; //from address for site emails
 	$mail_from_name = 'ivote'; //name to associate with your sent emails
 	$mail_reply_addr = "ivote@nku.edu"; //reply address for sent mails
 	$mail_reply_name = "ivote"; //set the name to associate with the reply
 	$mail_subject = 'iVote Mock-election'; //subject for the auth emails
 	$mail_html_msg = 'Thanks for deciding to participate in the Kentucky Campus Compact Mock Election!'; //HTML email to send to the users when they auth. Keep in mind that the vote link will be appended to the end of the mail
 	$mail_text_msg = 'Thanks for deciding to participate in the Kentucky Campus Compact Mock Election!'; //plain-text version of the above message


	/***
 	*    ___  ___      _____  _____ _       _____              __ _       
 	*    |  \/  |     /  ___||  _  | |     /  __ \            / _(_)      
 	*    | .  . |_   _\ `--. | | | | |     | /  \/ ___  _ __ | |_ _  __ _ 
 	*    | |\/| | | | |`--. \| | | | |     | |    / _ \| '_ \|  _| |/ _` |
 	*    | |  | | |_| /\__/ /\ \/' / |____ | \__/\ (_) | | | | | | | (_| |
 	*    \_|  |_/\__, \____/  \_/\_\_____/  \____/\___/|_| |_|_| |_|\__, |
 	*             __/ |                                              __/ |
 	*            |___/                                              |___/ 
 	* contains settings for mysql
 	*/
 	
	//the following will not need editing, they are there for the convenience of developers
	$sql_hostname = 'mysql1.nku.edu';
	$sql_db = 'cai0136';
	$sql_user = 'cai0136adm';
	$sql_pass = 'i341470U0136';


	/***
 	*    ___  ____              _____              __ _           _____       _   _                  
 	*    |  \/  (_)            /  __ \            / _(_)         |  _  |     | | (_)                 
 	*    | .  . |_ ___  ___    | /  \/ ___  _ __ | |_ _  __ _    | | | |_ __ | |_ _  ___  _ __  ___  
 	*    | |\/| | / __|/ __|   | |    / _ \| '_ \|  _| |/ _` |   | | | | '_ \| __| |/ _ \| '_ \/ __| 
 	*    | |  | | \__ \ (__ _  | \__/\ (_) | | | | | | | (_| |_  \ \_/ / |_) | |_| | (_) | | | \__ \ 
 	*    \_|  |_/_|___/\___(_)  \____/\___/|_| |_|_| |_|\__, (_)  \___/| .__/ \__|_|\___/|_| |_|___/ 
 	*                                                    __/ |         | |                           
 	*                                                   |___/          |_|                           
 	* pretty self explanatory
 	*/

 	//we use this for link generation in a few places
	$site_url = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['PHP_SELF']), '/\\'), 'vote');
	//used to generate the page titles
	$page_title = '2014 Mock Senatorial Election';
	//phrases displayed when the user is voting
	$vote_phrase = 'Vote for your choice for the U.S. Senate';
	$candidate_string = 'My choice for U.S. Senate:';

	//these are used to generate our drill down charts and the links to them. Only the top two will ever need changing
	$drill_keys = array(
		//keys must be in this order for maxChart.class.php to color them properly.
		'Democrat' => 'Allison Grimes',
		'Republican' => 'Mitch McConnell',
		'Other Candidate' => 'Other Candidate',
		'Undecided' => 'Undecided',
		'School' => 'ALL'
		);

	//date at which the election ends, D M YYYY format is shown, all acceptable formats are shown in the PHP documentation 
	$election_deadline = strtotime("7 September 2017");

	//generates our voting url based on the current date
	if ($election_deadline > time()){
		$vote_url = "vote/index.voteon.php";
	} else {
		$vote_url = "vote/index.php";
	}
?>