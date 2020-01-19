<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="{{ document_language }}" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="{{ document_language }}" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="{{ document_language }}" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="{{ document_language }}" class="no-js"> <!--<![endif]-->
<head>
{% block head %}
    {% include 'layout/head.tpl'|get_template %}
{% endblock %}
</head>
<body>
    <noscript>{{ "NoJavascript"|get_lang }}</noscript>
    <main id="main" dir="{{ text_direction }}" class="{{ section_name }} {{ login_class }}">
            {% if displayCookieUsageWarning == true %}
                <!-- START DISPLAY COOKIES VALIDATION -->
                <div class="toolbar-cookie alert-warning">
                    <form onSubmit="$(this).toggle('slow')" action="" method="post">
                        <input value=1 type="hidden" name="acceptCookies"/>
                        <div class="cookieUsageValidation">
                            {{ "YouAcceptCookies" | get_lang }}
                            <span style="margin-left:20px;" onclick="$(this).next().toggle('slow'); $(this).toggle('slow')">
                                ({{"More" | get_lang }})
                            </span>
                            <div style="display:none; margin:20px 0;">
                                {{ "HelpCookieUsageValidation" | get_lang}}
                            </div>
                            <span style="margin-left:20px;" onclick="$(this).parent().parent().submit()">
                                ({{"Accept" | get_lang }})
                            </span>
                        </div>
                    </form>
                </div>
            {% endif %}

            {% if show_header == true %}
                {% include 'layout/page_header.tpl'|get_template %}
            {% endif %}

            <div class="container-fluid">
                {% if show_course_shortcut is not null %}
                    <div id="cm-tools" class="nav-tools">
                        {{ show_course_shortcut }}
                    </div>
                {% endif %}
                {% block breadcrumb %}
                    {{ breadcrumb }}
                {% endblock %}
                {% include 'layout/course_navigation.tpl'|get_template %}
                {% block body %}
                    {{ content }}
                {% endblock %}
            </div>

            {% if show_footer == true %}
                {% include 'layout/page_footer.tpl'|get_template %}
            {% endif %}
     
    {% include 'layout/modals.tpl'|get_template %}
</body>
</html>
