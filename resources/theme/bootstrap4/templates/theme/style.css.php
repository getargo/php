:root {
{{ foreach ($this->config->theme->style ?? [] as $key => $val): }}
{{ if (trim($val) === '') continue }}
    --{{= str_replace ('_', '-', $key) }}: {{= trim ($val) }};
{{ endforeach }}
}

a,
a.page-link {
    color: var(--link-color, #438287);
}

a:hover,
a.page-link:hover {
    color: var(--link-color-hover, #205d5f);
}

blockquote {
    background-color: #ededed;
    border-left: 1rem solid #dcdcdc;
    padding-bottom: 1rem;
    padding-left: 2rem;
    padding-right: 2rem;
    padding-top: 1rem;
}

body {
    font-family: var(--sans-serif-fonts, sans-serif);
}

code {
    color: black;
    font-family: var(--monospace-fonts, monospace);
}

h1,
h2,
h3,
h4,
h5,
h6 {
    font-family: var(--sans-serif-fonts, sans-serif);
}

pre {
    font-fmaily: var(--monospace-fonts, monospace);
}

.Header {
    background-color: var(--header-background-color, #f7f7f7);
    background-image: var(--header-background-image, none);
    background-position: center top;
    background-repeat: no-repeat;
    background-size: cover;
    color: var(--header-font-color, black);
    margin: 0;
    padding: 1.5rem;
    text-align: center;
}

.Header p {
    font-style: italic;
}

.Header a,
.Header a:hover {
    color: var(--header-font-color, black);
}

.Menu {
    background-color: var(--header-background-color, #f7f7f7);
    margin: 0;
    padding: 0;
}

.MenuItem {
    font-size: 90%;
    font-weight: 550;
    white-space: nowrap;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.MenuItem a:hover {
    background-color: #fff;
}

.ArticleMeta address::before {
    content: "by ";
}

.ArticleHeader {
    margin-bottom: 2rem;
}

.ArticleBody {
    font-family: var(--serif-fonts, serif);
}

.Footer {
    color: var(--footer-font-color, black);
    background-color: var(--footer-background-color, #f7f7f7);
}
