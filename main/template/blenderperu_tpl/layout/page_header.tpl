<div id="navigation" class="notification-panel">
    {{ help_content }}
    {{ bug_notification }}
</div>
{% block topbar %}
    {% include 'layout/topbar.tpl'|get_template %}
{% endblock %}

{% if _u.logged == 1 and not user_in_anon_survey %}
    <script>
        $(document).ready(function () {
            $.get('{{ _p.web_main }}inc/ajax/message.ajax.php?a=get_count_message', function(data) {
                var countNotifications = (data.ms_friends + data.ms_groups + data.ms_inbox);
                if (countNotifications === 0 || isNaN(countNotifications)) {
                    $("#count_message_li").addClass('hidden');
                } else {
                    $("#count_message_li").removeClass('hidden');
                    $("#count_message").append(countNotifications);
                }
            });
        });
    </script>
{% endif %}


{% if header_extra_content is not null %}
    {{ header_extra_content }}
{% endif %}

{% block menu %}
    {% include 'layout/menu.tpl'|get_template %}
{% endblock %}

<div class="section-notifications">
    {% if _u.logged == 1 and not user_in_anon_survey %}
        <ul id="notifications" class="nav nav-pills pull-right">
        </ul>
    {% endif %}
    {{ accessibility }}
</div>


