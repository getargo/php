{{ if ($this->hasAtom): }}
    <link rel="alternate" type="application/atom+xml" href="atom.xml" />
{{ endif }}

{{ if ($this->hasJson): }}
    <link rel="alternate" type="application/json" href="index.json" />
{{ endif }}
