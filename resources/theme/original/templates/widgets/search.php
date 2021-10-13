            <div class="SidebarLayout__SidebarWidget">
                <form
                    action="https://duckduckgo.com/"
                    method="get"
                    class="Search"
                    onsubmit="
                        document.getElementById('search-q').value
                            = 'site:<?= $this->j(parse_url($this->config->general->url, PHP_URL_HOST)) ?> '
                            +  document.getElementById('search-input').value;
                    "
                >
                    <label class="Search__Tag">
                        <input type="hidden" id="search-q" name="q" value="" />
                        <input type="search" id="search-input" placeholder="Search &hellip;" class="input Search__Input">
                    </label>
                    <label class="Search__SubmitWrapper">
                        <input type="submit" value="Search" class="Search__SubmitButton">
                        <span class="Search__SearchIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0.2 3.5 20.42 20.75">
                                <g transform="translate(-560.008 -1318.754) rotate(45)">
                                    <g fill="none" stroke="currentColor" stroke-width="4px" transform="translate(1337 528)">
                                        <circle class="cls-2" stroke="none" cx="8.515" cy="8.515" r="8.515"></circle>
                                        <circle class="cls-3" fill="none" cx="8.515" cy="8.515" r="6.515"></circle>
                                    </g>
                                    <line stroke="currentColor" stroke-width="4px" fill="none" y2="7.618" transform="translate(1345.739 543.909)"></line>
                                </g>
                            </svg>
                        </span>
                    </label>
                </form>
            </div>
