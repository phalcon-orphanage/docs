<!doctype html>
<!--[if IE 8]>
<html lang="{{ language }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="{{ language }}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ language }}" class="no-js">
<!--<![endif]-->
<head>
    {#{%- include "include/meta.volt" -%}#}
    {#{%- include "include/icons.volt" -%}#}
    {%- include "include/analytics.volt" -%}

    {{- assets.outputCss('header_css') -}}

    <title>
        {{ get_title(false) ~ " - " ~ config.get('app').get('name', 'Phalcon Framework') }}
    </title>
</head>

<body class="with-top-navbar">
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#navbar-collapse-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand phalcon-logo" href="{{ url() }}">
                <span itemprop="name" class="sr-only">Phalcon Framework</span>
            </a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-collapse-main">
            <ul class="nav navbar-nav navbar-right m-r-0 hidden-xs">
                <li class="dropdown">
                    <a href="javascript:;"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        {{ locale.translate(language, 'community') }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="https://phalcon.link/forum"
                               target="_blank">
                                {{ locale.translate(language, 'forum') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/blog" target="_blank">
                                {{ locale.translate(language, 'blog') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/api" target="_blank">
                                {{ locale.translate(language, 'api') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/resources"
                               target="_blank">
                                {{ locale.translate(language, 'resources') }}
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="https://phalcon.link/f" target="_blank">
                                {{ locale.translate(language, 'facebook') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/t" target="_blank">
                                {{ locale.translate(language, 'twitter') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/g+" target="_blank">
                                {{ locale.translate(language, 'google_plus') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/gab" target="_blank">
                                {{ locale.translate(language, 'gab') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/{{ language }}/about" class="header-nav-link">
                        {{ locale.translate(language, 'contribute') }}
                    </a>
                </li>
                <li>
                    <a href="/{{ language }}/sponsors" class="header-nav-link">
                        {{ locale.translate(language, 'sponsors') }}
                    </a>
                </li>
                <li>
                    <a href="https://phalcon.link/fund" class="header-nav-link">
                        {{ locale.translate(language, 'support_us') }}
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav hidden-sm hidden-md hidden-lg">
                <a href="/{{ language }}/about" class="header-nav-link">
                    {{ locale.translate(language, 'contribute') }}
                </a>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            {{ sidebar }}
        </div>
        <div class="col-md-10" id="articles">
            {{ article }}
        </div>
    </div>
</div>

{%- include "include/footer.volt" -%}

{{- assets.outputJs('footer_js') -}}

<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
