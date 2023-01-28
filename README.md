# Hot Burgers 🍔

Hi 👋 Jiro Jasmin here.  
This project is a e-commerce app 🛍  
Scroll in the dynamic menu and add your favorite items in your cart. The items are stored in cart 🛒 until order placement or if you empty your cart.  
Moreoever, there is a custom admin panel to access the database 👨‍💻  
The use of a panel is recommanded for security (e.g prevents user from entering errors in the database with PHPMyAdmin) while also being more user-friendly for non-developers.  

---  
  
🚀 **[Click here to access to the online demo](https://hotburgers-berlin.000webhostapp.com/)** 🚀  
   
Alternatively, click here to watch a video demo:  
 
[![CLICK HERE FOR VIDEO DEMO](https://img.youtube.com/vi/9IDCPDBPxUg/0.jpg)](https://youtu.be/9IDCPDBPxUg)
  
---
  
To access to the panel, please go to [/admin](https://hotburgers-berlin.000webhostapp.com/admin)
and enter the following user credentials:  
> Username: burger-admin  
> Password: test1234!  
  
🔐 For security reason, please note that **you cannot make any change in the database (add, update or delete) on the online demo**. If you would like to do so, please download this repository with the database and try it on your localhost.

## 🔧 Tools

- Native PHP
- Native Javascript
- SQL
- Bootstrap & a bit of CSS

## 🪄 Features

- Dynamic pages
- SQL database connection using both **PDO** and **mysqli** PHP classes
- Handling cart with **session storage** in Javascript
- Authentication (sign up & sign in with password hash) in PHP
- Custom admin panel which allow the user to CRUD (Create, Read, Update, Delete) any items in the database through forms in PHP
- Server-side form data validation

## ⚠️ If you download this repository, make sure to  

### 1. Import the database
Download the *burgercode.sql* file and import it in your database (if you use PHPMyAdmin, click on "Import" in the top navbar).

### 2. Change the database information in code

You will need to add your Database Name, Username and Password in the following files:  

- /admin/config/database.php
- /admin/register.php
- /functions/cart.php

For now, I have set those to 'DB_NAME', 'DB_USER' and 'DB_PWD'.

Please note that for regular projects, there should only be one *database.php* file containing these info, for a more coherent and adaptable project. However here, **for demonstration purpose only**, I wanted to work both with PDO and mysqli PHP classes. That is why you need to update these several files if you want to launch the app on your machine.  
What you could do for production mode, for instance, is to remove the mysqli associated methods in *register.php* and in *cart.php*, and only work with the PDO class in *database.php* for the whole project.  

### 3. Be careful about the project structure when uploading online
  
🚮 If you do not need to create multiple users who can access the admin panel, please delete the following file: */admin/register.php*  
  
👥 If you need to create new users, and upload this file online, please secure it by restraining its access, or, create new user on development mode and then upload the user table in your database on your online host.  
🚨 Do not add any new user manually in your database using PHPMyAdmin because the password would be stored in clear.  
Creating a new user entry with */admin/register.php* will hash the password, while */admin/login.php* will be able to read it.  
  
Please be aware that this repository works on localhost. If you wish to host it online, depending on your server, you might need to change the file structure (e.g you could need a public_html folder and a tmp folder for session storage, etc.). As the file structure of a project can be server dependent, please check your host's docs for precise information.  

## 🔮 On the future of this project  
  
Please note that this project will have some improvements in the near future. For instance, I am currently working on creating a router in order to get more elegant URLs for a fully production-ready app.  
I am also thinking of adding some payment pages once one place their order, which would be linked with a payment API (or a fake one, just for demo purpose).  
If you have any suggestion or question regarding this project, do not hesitate to let me know! 😊  

[Click here](https://github.com/jiro-jasmin?tab=repositories) to access to all my online repositories.  
Thank you for visiting my profile!  

If you would like to reach me, please contact me on my [LinkedIn profile here](https://www.linkedin.com/in/jiro-jasmin).
