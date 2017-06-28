<!doctype html>
<!--[if IE 8]>
<html lang="{{ language }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="{{ language }}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ language }}" class="no-js">
<!--<![endif]-->
<head>
    {%- include "include/meta.volt" -%}
    {%- include "include/icons.volt" -%}
    {%- include "include/analytics.volt" -%}

    {{- assets.outputCss('header_css') -}}

    <title>
        Phalcon Documentation - {{ config.get('app').get('name', 'Phalcon Framework') }}
    </title>
</head>

<body class="with-top-navbar">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid p-x-md">
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
                <img src="//static.phalconphp.com/www/images/phalcon1.png" alt="Phalcon Logo">
            </a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-collapse-main">
            <ul class="nav navbar-nav navbar-right m-r-0">
                <li class="dropdown">
                    <a href="javascript:;"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Community
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="https://phalcon.link/forum"
                               target="_blank">
                                Forum
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/blog" target="_blank">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/resources"
                               target="_blank">
                                Resources
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="https://phalcon.link/f" target="_blank">
                                Facebook
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/t" target="_blank">
                                Twitter
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/g+" target="_blank">
                                Google+
                            </a>
                        </li>
                        <li>
                            <a href="https://phalcon.link/gab" target="_blank">
                                Gab.ai
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="https://phalcon.link/about" class="header-nav-link">
                        About
                    </a>
                </li>
                <li>
                    <a href="https://phalcon.link/sponsors" class="header-nav-link">
                        Sponsors
                    </a>
                </li>
                <li>
                    <a href="https://phalcon.link/fund" class="header-nav-link">
                        Support Us
                    </a>
                </li>
                <li>
                    <a href="https://phalcon.link/fund" class="btn btn-xs btn-success">
                        DOWNLOAD
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav hidden-sm hidden-md hidden-lg">
                <div class="doc-menu">
                    <h4>Doc menu</h4>
                    {{ sidebar }}
                </div>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid article-page-wrap">
    <div class="row">
        <div class="col-md-2 sidebar hidden-xs">
            {{ sidebar }}
        </div>
        <div class="m-t-md m-b-lg" id="articles">
            <div class="article-content">
                {{ article }}
            </div>
        </div>
        {%- include "include/footer.volt" -%}
    </div>
</div>

{{- assets.outputJs('footer_js') -}}

<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
