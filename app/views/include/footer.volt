<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-sm-3">
                <h4>{{ locale.translate(language, 'download') }}</h4>
                <ul>
                    <li><a href="{{ url(language ~ '/download') }}">{{ locale.translate(language, 'installing_phalcon_php') }}</a></li>
                    {#<li><a href="{{ utils.getDocsUrl(language) }}/index.html" class="header-nav-link" target="_blank">{{ locale.translate(language, 'documentation') }}</a></li>#}
                    <li><a href="http://api.phalconphp.com">API</a></li>
                    {#<li><a href="{{ utils.getDocsUrl(language) }}/reference/tutorial.html">{{ locale.translate(language, 'tutorial') }}</a></li>#}
                    {#<li><a href="{{ utils.getDocsUrl(language) }}/reference/tutorial.html#sample-applications">{{ locale.translate(language, 'sample_applications') }}</a></li>#}
                    <li><a href="{{ url(language ~ '/support') }}">{{ locale.translate(language, 'support') }}</a></li>
                </ul>
            </div>
            <div class="col-xs-4 col-sm-3">
                <h4>{{ locale.translate(language, 'community') }}</h4>
                <ul>
                    <li><a href="https://phalcon.link/forum" class="header-nav-link" target="_blank">{{ locale.translate(language, 'forum') }}</a></li>
                    <li><a href="https://phalcon.link/github">GitHub</a></li>
                    <li><a href="https://github.com/phalcon/cphalcon/issues">{{ locale.translate(language, 'issue_tracker') }}</a></li>
                    <li><a href="https://stackoverflow.com/questions/tagged/phalcon">{{ locale.translate(language, 'stack_overflow') }}</a></li>
                    <li><a href="{{ url(language ~ '/testimonials') }}">{{ locale.translate(language, 'testimonials') }}</a></li>
                    <li><a href="https://phalcon.link/builtwith">{{ locale.translate(language, 'built_with_phalcon') }}</a></li>
                    <li><a href="https://phalcon.link/store">{{ locale.translate(language, 'store') }}</a></li>
                </ul>
            </div>
            <div class="col-xs-4 col-sm-2">
                <h4>{{ locale.translate(language, 'about') }}</h4>
                <ul>
                    <li><a class="link-black" href="{{ url(language ~ '/blog') }}">{{ locale.translate(language, 'blog') }}</a></li>
                    <li><a class="link-black" href="{{ url(language ~ '/about') }}">{{ locale.translate(language, 'about') }}</a></li>
                    <li><a class="link-black" href="{{ url(language ~ '/team') }}">{{ locale.translate(language, 'team') }}</a></li>
                    <li><a class="link-black" href="https://phalcon.link/roadmap">{{ locale.translate(language, 'roadmap') }}</a></li>
                    <li><a class="link-black" href="https://phalcon.link/donate">{{ locale.translate(language, 'donate') }}</a></li>
                    <li><a class="link-black" href="{{ url(language ~ '/consulting') }}">{{ locale.translate(language, 'consulting') }}</a></li>
                    <li><a class="link-black" href="{{ url(language ~ '/hosting') }}">{{ locale.translate(language, 'hosting') }}</a></li>
                </ul>
            </div>
            <div id="license-spaccer" class="visible-xs"></div>
            <div id="license-wrapper" class="col-xs-12 col-sm-4">
                <p class="license">
                    {{ locale.translate(language, 'license_new_bsd') }}
                </p>
            </div>
        </div>
    </div>
</footer>
