{% extends 'layout/layout_1_col.tpl'|get_template %}

{% block content %}

    {{ form_search }}

    {{ dump(sessions) }}


    <table id="report_session" class="table table-hover">
        <tr>
            <th>
                #
            </th>
            <th>
                {{ 'SessionName' | get_lang }}
            </th>
            <th>
                {{ 'SessionDurationTitle' | get_lang }}
            </th>
            <th>
                {{ 'N° de Usuarios registrados' | get_lang }}
            </th>
            <th>
                {{ 'Número de cursos' | get_lang }}
            </th>
        </tr>
        {% for session in sessions %}
            <tr>
                <td>
                    {{ session.id }}
                </td>
                <td>
                    {{ session.name }}
                </td>
                <td>

                </td>
            </tr>
        {% endfor %}
    </table>


{% endblock %}