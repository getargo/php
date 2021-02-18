# Changelog

This package uses [Romantic Versioning](http://blog.legacyteam.info/2015/12/romver-romantic-versioning/).

## 1.2.0

This release comes with a new theme, `argo/bootstrap4`. To try it, edit your
General Config to set `"theme": "argo/bootstrap4"`.

The previous `default` theme has been renamed to `argo/original`.

### UPGRADING

Upgrading should be almost completely automatic. However, custom theme work in
your `_theme` directory should be moved manually to `_theme/custom/{$theme}`.
For example, you should use `_theme/custom/argo/original` (instead of just
`custom`). The changed location allows you to switch between themes without
having to re-edit your custom work each time you switch.

### Added

- The Draft page now shows the provisional URL based on the current date and title of the draft.

- A "Featured Posts" config is now available; it uses the same format as the blogroll config.

- Tags can now be deleted via the tag admin page.

- Posts now support the `<!-- more -->` tag, so that in the post indexes, a "Read More" link shows up.

### Changed

- You can now open the local site storage folder from any admin screen; the link is at the top right of each screen.

- Custom theme work is now done not in `custom/` but in `_theme/custom/{$theme}`; this allows you to switch between themes, and maintain the custom theme work in each one.

- Posts now "know" what index they are in, so that saving a post rebuilds only that index, not all indexes. This is a performance improvement.

- All content items now support $prev and $next.

- All content items now support tags (except tags themselves).

- The page names "category" and "categories" are now reserved.

### Fixed

- Images and links in content item editing previews now point to the preview server, not the admin server, so that they display properly in preview.

- Pages without tags now show up properly for editing.

### Internals

- Composer now included
- Multi-level container configuration (domain, infra, app, ui)
- No more "extra" in composer.json
- Admin: post draft, post, page, tag, all now use bodyPreview(), not body()
- Admin: generic item now shows the URL to which the item will be published
- Admin: generic item now always shows a Delete button
- Admin: sidebar now links to Featured Config
- Admin: "Open Local Docroot" now in top right corner, displayed as folder path and name
- Themes are now loaded via Composer
- Themes now use "vendor/package" naming convention
- Old theme "default" now named "argo/original"
- New theme "argo/bootstrap4" is now the default for new sites
- Themes now have their own Build.php code
- Index-page posts now show a "More" link
- Renamed Argo\UseCase namespace to Argo\App
- Theme name is now part of General config
- Pages now get tags
- Tags can now be trashed
- The _argo/admin.json config now carries an Argo version value
- Themes now carry their own default configuration files
- Each Post can now know which index page it is on; this makes index rebuilds faster.
- The internal Folio now tracks custom prepend and append ("penders") templates
- All content items get tags (except Tag items), as well as prev and next values
- Invalid page names went from  ['author', 'authors', 'post', 'posts', 'tag', 'tags', 'theme'];
  to ['author', 'authors', 'category', 'categories', 'post', 'posts', 'tag', 'tags', 'theme'];
- Action classes now get the explicit UseCase, not just the Container
- Namepsace Argo\Infrastructure renamed to Argo\Infra
- Preflight now handles in-place upgrades
- Timezone discovery now sets local format to en_US, to suit DateTime expectations

## 1.1.0

### Added

Admin screens now use AdminLTE 3 for their UI.

A .htaccess file is created at site initialization.

### Changed

Content items can now specify their markup format.

### Fixed

Drafts now show images properly.


## 1.0.0

Initial release.
