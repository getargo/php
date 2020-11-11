<?php if ($this->hasAtom): ?>
    <link rel="alternate" type="application/atom+xml" href="atom.xml" />
<?php endif; ?>

<?php if ($this->hasJson): ?>
    <link rel="alternate" type="application/json" href="index.json" />
<?php endif; ?>

<link rel="preload" href="/menu.shtml" />
<link rel="preload" href="/blogroll.shtml" />
<link rel="preload" href="/posts/months/index.shtml" />
<link rel="preload" href="/tags/index.shtml" />
