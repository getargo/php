# Changelog

This package uses [Romantic Versioning](http://blog.legacyteam.info/2015/12/romver-romantic-versioning/).

## 1.2.0

### UPGRADING

This release comes with a new theme, "argo/bootstrap4". To try it, edit your
General Config to set `"theme": "argo/bootstrap4"`.

The previous `default` theme has been renamed to `argo/original`.

Custom theme work in your `_theme` directory should now be in
`_theme/custom/{$theme}`. For example, you should use
`_theme/custom/argo/default` (instead of just `custom`). This allows you to
switch between themes without having to re-edit your custom work each time you
switch.

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

### Other

Updated docs and tests.


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

