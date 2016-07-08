<!doctype html>
<html>
<head>
    <title>{% block title %}{% endblock %}</title>
    {% block meta %}{% endblock %}
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    {% include 'partials/favicons.volt' %}
    <link rel="stylesheet" href="/static/{{ application }}/{{ module }}/css/vendor.css" type="text/css"/>
    <link rel="stylesheet" href="/static/{{ application }}/{{ module }}/css/main.css" type="text/css"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
    <script src="/static/{{ application }}/{{ module }}/js/vendor.js"></script>
</head>
<body class="">
{% include 'partials/header.volt' %}

<main>
    <div class="column">{{ flashSession.output() }}</div>
    <div class="ui container">
        <div class="row">
            {% block content %}{% endblock %}
        </div>
    </div>
</main>

{% include 'partials/footer.volt' %}

<noscript>
    {{ _('errors.javascriptDisabled') }}
</noscript>
<script src="/static/{{ application }}/{{ module }}/js/main.js"></script>
</body>
</html>
