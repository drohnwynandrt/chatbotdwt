# LINE bot in PHP
Simple template to setup LINE bot in PHP on Heroku.

### Steps to setup

1. Clone this repo
2. Create a Heroku account and install Heroku CLI tools (if first time Heroku)
3. Heroku create (command line inside your project)
4. Heroku config:set  or web console to configure the CHANNEL_ACCESS_TOKEN and CHANNEL_SECRET
5. Set your webhook on LINE console of your channel to your Heroku url 
6. Git add -A; git commit -m "First app"; git push Heroku master  (deploy files to Heroku)
7. Go to your bot (use QR code) and try to say "hallo" or "sticker"
8. Happy coding, read the LINE API documentation for all features!




### Configure ENV variables on Heroku

CHANNEL_ACCESS_TOKEN=copy_and_paste_from_line_developer_console

CHANNEL_SECRET=copy_and_paste_from_line_developer_console

PASS_SIGNATURE=true