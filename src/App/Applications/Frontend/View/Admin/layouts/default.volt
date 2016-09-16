<!doctype html>
<html>
<head>
    <title>{% block title %}{% endblock %}</title>
    {% block meta %}{% endblock %}
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    {% include 'partials/favicons.volt' %}
    <link rel="stylesheet" href="/static/{{ application }}/{{ module }}/css/vendor.css" type="text/css"/>
    <link rel="stylesheet" href="/static/{{ application }}/{{ module }}/css/main.css" type="text/css"/>
    <script src="/static/{{ application }}/{{ module }}/js/vendor.js" charset="utf-8"></script>
</head>
<body>
{% include 'partials/header.volt' %}

<main>
    {{ flashSession.output() }}

    {% block content %}{% endblock %}
</main>

{% include 'partials/footer.volt' %}

<noscript>
    {{ _('errors.javascriptDisabled') }}
</noscript>
<script src="/static/{{ application }}/{{ module }}/js/main.js" charset="utf-8"></script>
</body>
</html>
