# a repository of links

Pretty much exactly what it sounds like. A very simple site that lets you post links and text for safe keeping. Like bookmarks, or del.icio.us, but better.

## installation + usage

Expects PHP 5.5+ to use the password hashing functionality.

To use this on your own server, it's fairly simple. The database layout is in `links.sql`.

You should rename `dbconn_mysql.example.php` to `dbconn_mysql.php` and fill it in with the relevant credentials.

Open up your favorite text editor and do a find-and-replace for `arepository.com` and probably `/of/links/` to match whatever hostname and path you're installing this into.

To get pretty URLs working, just use the `links-lighty.conf` configuration file in lighttpd. If you're not using lighttpd, you'll have to transcribe it to your own config, but it's pretty simple.

Since part of this depends on `/dev/urandom`, I don't think this'll work well on a Windows server.

## user invite codes

Right now the only way to get an invite code is to manually add one to the database's `invite_codes` table.

## to do / stuff / notes

I'd like to recreate this project with React and Laravel and other stuff like that, since this is so simple.

Right now the `report_error()` function just spits out the error, should switch that to logging...