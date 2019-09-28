## Getting Started
Run these commands on your terminal to setup the project.

* composer install
* php artisan migrate
* php artisan passport:install

## Signing Up
To create a new user account submit the following data below to '/api/auth/signup'.

<img src="https://github.com/buddyy93/kkr_laravel_api/blob/master/repo_images/Signup.png" height="30%" width="50%">

Be sure to set the headers as listed below
```
Content-Type: application/json
X-Requested-With: XMLHttpRequest
```
## Login
Now you can use those credentials to login by submitting following data to '/api/auth/login'.

<img src="https://github.com/buddyy93/kkr_laravel_api/blob/master/repo_images/Login.png" height="40%" width="60%">

## Making Request
Once your are logged in you can make a request to the api, make sure to set authorization on the header and pass your access token.
```
Authorization: Bearer youraccesstoken
```
Now you should be able to use the api.

<img src="https://github.com/buddyy93/kkr_laravel_api/blob/master/repo_images/Data.png" height="40%" width="60%">

## Unauthenticated Access

<img src="https://github.com/buddyy93/kkr_laravel_api/blob/master/repo_images/Unauthhenticated.png" height="40%" width="60%">

You shouldn't see this if you did everything mentioned above.
