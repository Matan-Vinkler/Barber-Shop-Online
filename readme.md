Setup Website:

Import Database:
1. Go to your PHPMyAdmin page.
2. Go to "New" Section.
3. Click on the "Import" button at the top of the page.
4. Choose the file `mydatabase.sql`.
5. Click on the "Import" button at the bottom of the page.

Enable Mail:
1. Edit `../../php/php.ini`:

    SMTP=localhost
    smtp_port=587
    sendmail_from = <your-email@gmail.com>
    sendmail_path = <your path to `sendmail.exe`>

2. Go to https://myaccount.google.com/security and add `App Password` from `Signing In to Google`

3. Edit `../../sendmail/sendmail.ini`:

    smtp_server=smtp.gmail.com
    smtp_port=587
    error_logfile=error.log
    debug_logfile=debug.log
    auth_username=<your-email@gmail.com>
    auth_password=<your-password-from-app-password>