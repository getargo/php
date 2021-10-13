                <section class="my-4">
                    {{ form [
                        'action' => 'https://duckduckgo.com/',
                        'method' => 'get',
                    ] }}
                        <div class="input-group">
                            {{= formHidden [
                                'name' => 'sites',
                                'value' => parse_url($this->config->general->url, PHP_URL_HOST),
                            ] }}
                            {{= formSearch [
                                'name' => 'q',
                                'class' => 'form-control',
                                'placeholder' => 'Search ...',
                            ] }}
                            <span class="input-group-append">
                                {{= formSubmit [
                                    'class' => 'btn btn-secondary',
                                    'value' => 'Go!',
                                ] }}
                            </span>
                        </div>
                    </form>
                 </section>
