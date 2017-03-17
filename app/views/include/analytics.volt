{%- if (not config.get('google').get('analytics', '') is empty) -%}
    {%-
        set analytics_url   = config.get('app').get('url', 'https://phalconphp.com') ~ router.getRewriteUri(),
            analytics_title = get_title(false) ~ " - " ~ config.get('app').get('name', 'Phalcon Framework')
    -%}
    <!-- Google Analytics -->
    <script type="application/javascript">
        window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
        ga("create", "{{ config.get('google').get('analytics', '') }}", "auto");
        ga("send", "pageview", {
            "page": "{{ analytics_url }}",
            "title": "{{ analytics_title }}"
        });
    </script>
    <script async src='https://www.google-analytics.com/analytics.js'></script>
    <!-- End Google Analytics -->
{%- endif -%}
