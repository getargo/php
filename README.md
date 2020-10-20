# Argo

Argo is a flat-file static-site blog authoring and building system. It presents
a browser interface for ease of use, and synchronizes with any hosting service
using Git or rsync.

Because Argo keeps all your content on your computer, no hosting service can
ever deprive you of your content by shutting down your account. The content you
create is always on your own computer. This makes Argo sites more resistant to
censorship. Further, because Argo is a flat-file static-site system, remote
hosting requirements are minimal. Only a web server is needed.

## Warnings

This package is **IS NOT** a server application. **DO NOT** install
it on a server.

Instead, this package is an **end-user** application, to be installed on
firewalled client computers.

This package **DOES NOT** use Semantic Versioning. It is intended primarily as a
product, not as a set of libraries.

## Installation

### Techy Nerds

First, [get Composer](https://getcomposer.org), then issue the following commands:

```
% git clone git@github.com:getargo/php argo
% cd argo
% composer install
% php ./bin/admin.php
```

That will open Argo in your client browser. Use `Ctrl-C` to stop the Argo app.

To update the Argo code, change to the `argo` directory, then issue
`git pull && composer update`.


### Normal Well-Adjusted People

Download and double-click the Mac- or Linux-based desktop appliction from
[getargo/app](https://github.com/getargo/app).

Linux users may need to install PHP first, if it is not already present.

Mac users may find that OS X will not launch Argo, because it is not from the
App Store. To get around this, open `System Preferences` -> `Security & Privacy`
-> `General`, and allow apps downloaded from `App Store and identified
developers`. Then try to launch Argo again.

## Getting Started

Watch this video.
