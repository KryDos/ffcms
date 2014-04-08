{% import 'macro/notify.tpl' as notify %}
{% if add.notify.time_delay %}
    {{ notify.error(language.comments_api_delay_exception) }}
{% endif %}
{% if add.notify.wrong_text %}
    {{ notify.error(language.comments_api_incorrent_length) }}
{% endif %}
{% for comment in local %}
    <div class="media">
        <a class="pull-left" href="{{ system.url }}/user/id{{ comment.author_id }}">
            <img class="media-object img-responsive" src="{{ system.script_url }}/{{ comment.author_avatar }}" style="width: 64px;height: 64px;">
        </a>
        <div class="media-body">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ system.url }}/user/id{{ comment.author_id }}">{{ comment.author_nick }}</a>, {{ comment.comment_date }}
                    <div class="pull-right">
                        {% if comment.can_delete %}<a href="#comment_site" onclick="return deletecomment({{ comment.comment_id }});" data-toggle="tooltip" data-placement="top" title="{{ language.comment_text_delete_link }}" class="tooltip-show"><i class="fa fa-ban"></i></a> {% endif %}
                        {% if comment.can_edit %}<a href="#edit-comment" data-toggle="modal" class="edit-comment tooltip-show" data-toggle="tooltip" data-placement="top" title="{{ language.comment_text_edit_link }}" onclick="return editcomment({{ comment.comment_id }})"><i class="fa fa-pencil-square-o"></i></a> {% endif %}
                        {% if user.id > 0 %}<a onclick="replayto('{{ comment.author_nick }}')" href="#comment_value" data-toggle="tooltip" data-placement="top" title="{{ language.comments_text_answerto }}" class="tooltip-show"><i class="fa fa-quote-right"></i></a> {% endif %}
                    </div>
                </div>
                <div class="panel-body">
                    {{ comment.comment_text }}
                </div>
            </div>
        </div>
    </div>
{% endfor %}