# Jakarta Camera
This project was generated with Laravel Blade
## Installation Package
run `composer install` and waiting for installed packages <br>
run `npm i --legacy-peer-deps` and waiting for installed packages

## IMPORT DB
import name of DB.sql to your server 

## Connected DB
updating file `.env` and set your connection username, password, and DB name

## MAIL CONNECTION
this backend have verification email after login, update `.env` on MAIL_SERVER and set your connection correctly

## Get Lastest Apps from GITHUB
run `git pull` and waiting for new apps

## CORS ORIGIN
if your frontend cant access API Backend, now you need to Add the following code to `bootstrap/app.php` : <br>
`header('Access-Control-Allow-Origin: *');`<br>
`header('Access-Control-Allow-Methods: *');`<br>
`header('Access-Control-Allow-Headers: *');`<br>


## DEBUG
`send verification email` if your verification email has failed sending the email edit `vendor/email` location in `vendor\swiftmailer\swiftmailer\lib\classes\Swift\Transport\StreamBuffer.php`<br>
and edit on line `:250 -> $option = [];` change to `$options['ssl'] = array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true);` <br>
because vendor doesn't commit to github