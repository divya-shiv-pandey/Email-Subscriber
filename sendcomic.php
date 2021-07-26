<?php
include_once dirname(__FILE__).'/config.php';

$url='https://c.xkcd.com/random/comic/';
$headers=get_headers($url,1);
$unparsedurl=$headers['Location'][0]; 
$parsedurl= parse_url($unparsedurl,PHP_URL_PATH);
$code=filter_var($parsedurl, FILTER_SANITIZE_NUMBER_INT);
$url = 'https://xkcd.com/'.$code.'/info.0.json'; 
$imgdata = file_get_contents($url); 
$char = json_decode($imgdata);
$image=$char->img;

$sql = "SELECT email, name, hash FROM users WHERE active is NOT NULL";
$stmt=mysqli_query($conn,$sql);
$rows = array();

$mail->addStringAttachment(file_get_contents($image),'xkcd.png');         
$mail->isHTML(true);                                  
$mail->Subject = 'XKCD Comic';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $verify = 'https';
} else {
    $verify = 'http';
}
while($row = mysqli_fetch_assoc($stmt)){
    $mail->ClearAllRecipients();
    $mail->addAddress($row['email'], $row['name']);
    $mail->Body = 'Your free copy of  XKCD is attached. Have fun!<br><br> <img src='.$image.'> <br><br> <a href='.$verify.'://'.$_SERVER['HTTP_HOST'].'/unsubs.php?id='.$row['hash'].'>Click here to Unsubscribe.</a>'."\r\n" ;
    // echo $row['email']."  name:". $row['name']."   ";
    $mail->send();
}
?>
