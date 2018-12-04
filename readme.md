

## Automated Mailer

A few months back, I have a friend-worked as a remote english teacher-who laments that he have to collate a collosal amount of emails (564 in total, I might be wrong...). Those emails contain information about the students that has worked with over the years. It contained the student's email address as well, which is the data that he's after. He wanted to send his former students an email that would urge them to resume their lessons with him for half the price of the english teaching agency that he used to work in. I realized that his predicament can be solved using laravel, so I took it upon myself to develop an app that rummage thru my friend's gmail account, compiled all of his student's email, seed it to my database, and call it whenever he wants to send a massive email spree to his students.<br>

my friend's email list that contain his student's information looks like this  <br><br>
![alt text](https://github.com/naruka1023/mailer/blob/master/emailList.jpg)
<br><br>

This is one of the email's individual content, <br><br>
![alt text](https://github.com/naruka1023/mailer/blob/master/individualEmails.jpg)
<br><br>

this is a snippet of the list of names and emails that I collated from my friend's email List using Laravel's seeding capabilities. Unfortunately, the code that is responsible for pulling all the data from my friend's email could not be found... I will find it and integrate it into this codebase eventually  <br><br>
![alt text](https://github.com/naruka1023/mailer/blob/master/collated.jpg)
<br><br>

This is the email that my automated mailer sent to all everyone in the collated email list, that is now being housed inside my database  <br><br>
![alt text](https://github.com/naruka1023/mailer/blob/master/screencapture-mail-google-mail-u-0-2018-12-04-12_29_51.png)
<br><br>

I used Redis and socket IO to implement a loading bar that shows how many emails have been sent. <br><br>

a link to a demonstration of the app can be found here <br><br>
https://www.youtube.com/watch?v=qE51tocJTzU
