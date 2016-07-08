<h1>{{ code }}</h1>

<h5>{{ error.message() }}</h5>

{% if displayError and displayError == true %}
    <div>in {{ error.file()}} on line {{ error.line()}}</div>

    {% if error.isException() %}
        <pre>
            {{ error.exception().getTraceAsString() }}
        </pre>
    {% endif %}
{% endif %}
