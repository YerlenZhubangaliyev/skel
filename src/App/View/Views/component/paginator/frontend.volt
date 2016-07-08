<ul class="pagination">
    {% if prevPage %}
        <li class="waves-effect"><a href="{{ prevPage }}"><i class="material-icons">chevron_left</i></a></li>
    {% else %}
        <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
    {% endif %}

    {% for i, page in pageRange %}
        <li class="{{ page == currentPage ? 'active': 'waves-effect' }}">
            <a href="{{ pageRangeUrl[i] }}">{{ page }}</a>
        </li>
    {% endfor %}
    {% if nextPage %}
        <li class="waves-effect"><a href="{{ nextPage }}"><i class="material-icons">chevron_right</i></a></li>
    {% else %}
        <li class="disabled"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
    {% endif %}
</ul>
