<div class="well">
    <h4 class="centered">{{ language.tagcloud_title }}</h4>
    <p>
    {% for item in local %}
       <a href="{{ system.url }}/news/tag/{{ item.tag|url_encode }}.html" class="label" title="{{ language.tagcloud_alttext }} {{ item.count }}">{{ item.tag|e }}</a>
    {% else %}
       {{ language.tagcloud_notfound }}
    {% endfor %}
    </p>
</div>