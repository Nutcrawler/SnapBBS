Readme:

SnapBBS Version 0.9.3

Changelog----
0.9.3:
Auto-login as a guest if the BBS allows for guests.
Load previous color values on the Appearance settings page.
Add link to User list on the Admin Control Panel.

0.9.2:
first public release

Thanks for downloading SnapBBS.

Requirements-----
PHP5 and the PHP GD library.

Usage-----
All settings are stored in threadlist.xml. You can tweak them from there. Options are:

boardname="BoardName" 
-- the name displayed at the top of every page

signups="public" or signups="private" 
--whether to allow anyone to sign up, or to keep the board invite-only.

guests="yes" or guests="no"
--whether to allow guest access. Guests have read-only access to the board.

The admin password is "Password" by default, you'll want to change this on the first login.

After that, setup is complete. It's ready to run.

Contributors----
Mixie The CryptoKitten
nonguru -- time_delta function
htpasswd.inc contains code Copyright (C) 2004,2005 Jarno Elonen <elonen@iki.fi> Please review htpasswd.inc for the license and copyright notice.