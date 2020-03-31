<footer class="footer">
<div class="container">
    {% if plugin_pre_footer is not null %}
        <div id="plugin_pre_footer">
            {{ plugin_pre_footer }}
        </div>
    {% endif %}
    <section class="sub-footer">
        <div class="row">
            <div class="col-xs-12 col-md-4">

                {% if _u.status == 1 %}
                <strong>Soporte técnico:</strong>
                <a href="mailto:soporte@aula-virtual.cl" target="_blank">soporte@aula-virtual.cl</a>
                {% endif %}

                {#{% if administrator_name is not null %}
                    <div class="administrator-name">
                        {{ administrator_name }}
                    </div>
                {% endif %}#}
                {#{% if session_teachers is not null %}
                <div class="session-teachers">
                    {{ session_teachers }}
                </div>
                {% endif %}
                {% if teachers is not null %}
                <div class="teachers">
                    {{ teachers }}
                </div>
                {% endif %}#}
                {% if plugin_footer_left is not null %}
                <div id="plugin_footer_left">
                    {{ plugin_footer_left }}
                </div>
                {% endif %}
            </div>
            <div class="col-xs-12 col-md-4">
                {% if plugin_footer_center is not null %}
                    <div id="plugin_footer_center">
                        {{ plugin_footer_center }}
                    </div>
                {% endif %}
            </div>
            <div class="col-xs-12 col-md-4 text-right">
                Aula Virtual proporcionada por:
                <img width="100px" src="{{ _p.web_css_theme }}images/educacion_chile.svg" />
                {#{% if _s.software_name is not empty %}
                    <div class="software-name">
                        <a href="{{_p.web}}" target="_blank">
                            {{ "PoweredByX" |get_lang | format(_s.software_name) }}
                        </a>&copy; {{ "now"|date("Y") }}
                    </div>
                {% endif %}#}
                {% if plugin_footer_right is not null %}
                    <div id="plugin_footer_right">
                        {{ plugin_footer_right }}
                    </div>
                {% endif %}
            </div>
        </div>
        {% if footer_extra_content  %}
            {{ footer_extra_content }}
        {% endif %}
    </section>
</div>
</footer>

{{ execution_stats }}
