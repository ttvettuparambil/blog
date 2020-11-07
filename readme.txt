CODE AUTHOR: Ava
Converting static blog page into Dynamic Page.
Index.php: Client side front end.
login.php: Admin side login
Signup: Admin Side Signup
Single: Code for single blog post
path: Defines custom paths for both BASE_URL and ROOT_PATH
formErrors.php: Checks if there is 1 or more error in the signup form and if so prevent the user from signing in.
validateUser:Store all errors related to input fields in both signin and signup forms.
messages.php:Contains code that displays that the user is logged in exactly once when user is signed up.
adminHeader.php: Common header for when an admin logs in.
adminSidebar.php: Common sidebar for admin side.


//signup Page
In the signup page change code to login by
<a href="<?php echo BASE_URL. '/login.php'?>">Signin</a>

//login Page
In the login page change code to signup by
<a href="<?php echo BASE_URL. '/signup.php'?>">Signin</a>

Note:
Select * from tablename where condition limit 1; Limit 1 is used to indicate that when the query has found a match it is to be terminated immediately.
