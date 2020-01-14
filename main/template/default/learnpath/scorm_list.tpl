{% if data_list is not empty %}
<div id="learning_path_toc" class="scorm-list">
    <div class="scorm-title">
        <h4>{{ lp_title_scorm }}</h4>
    </div>
    <div class="scorm-body">
        <div id="inner_lp_toc" class="inner_lp_toc scrollbar-light">
            {% for item in data_list %}
            <div id="toc_{{ item.id }}" class="{{ item.class }} item-{{ item.type }}">
                {% if item.type == 'dir' %}
                <div class="section {{ item.css_level }}" title="{{ item.description | striptags | e('html') }}">
                    {{ item.title }}
                </div>
                {% else %}
                <div class="item {{ item.css_level }}" title="{{ item.description | striptags | e('html') }}">
                    <a name="atoc_{{ item.id }}"></a>
                    <a data-type="type-{{ item.type }}" class="items-list"  href="#"
                       onclick="switch_item('{{ item.current_id }}','{{ item.id }}'); return false;">
                        {{ item.title }}
                    </a>
                </div>
                {% endif %}
            </div>
            {% endfor %}
        </div>
    </div>
</div>
{% endif %}

{% if data_panel is not empty %}
<<<<<<< HEAD

<div id="learning_path_toc" class="scorm-collapse">
=======
<div id="learning_path_toc">
>>>>>>> 61362f59ef9a2597e75561cb63dbefb136098be0
    <div class="scorm-title">
        <h4>
             {{ lp_title_scorm }}
        </h4>
    </div>
<<<<<<< HEAD
    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <ul class="scorm-collapse-list">
        {% for item in data_panel %}
            {% if item.type == 'dir' %}
                <li class="type-dir">
                    <div class="panel panel-default {{ item.parent ? 'lower':'higher' }}" data-lp-id="{{ item.id }}"
                         {{ item.parent ? 'data-lp-parent="' ~ item.parent ~ '"' : '' }}>
                        <div class="status-heading">
                            <div class="panel-heading" role="tab" id="heading-{{ item.id }}">
                                <h4>
                                    <a class="item-header" role="button" data-toggle="collapse"
                                        data-parent="#scorm-panel{{ item.parent ? '-' ~ item.parent : '' }}"
                                        href="#collapse-{{ item.id }}" aria-expanded="true"
                                        aria-controls="collapse-{{ item.id }}">
                                        {{ item.title }}
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div id="collapse-{{ item.id }}" class="panel-collapse collapse {{ item.parent_current }}"
                             role="tabpanel" aria-labelledby="heading-{{ item.id }}">
                            <div class="panel-body">
                                <ul class="list">
                                    {% set counter = 0 %}
                                    {% set final = item.children|length %}
                                    {% for subitem in item.children %}
                                    {% set counter = counter + 1 %}
                                    <li id="toc_{{ subitem.id }}"
                                        class="{{ subitem.class }} {{ subitem.type }} {{ counter == final ? 'final':'' }}">
                                        <div class="sub-item item-{{ subitem.type }}">
                                            <a name="atoc_{{ subitem.id }}"></a>
                                            <a data-type="type-{{ subitem.type }}" class="item-action" href="#"
                                               onclick="switch_item('{{ subitem.current_id }}','{{ subitem.id }}'); return false;">
                                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                                {{ subitem.title }}
                                            </a>
                                        </div>
                                    </li>
                                    {% endfor %}
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            {% else %}
                <li id="toc_{{ item.id }}" class="{{ item.class }} item-{{ item.type }}">
                    <div class="sub-item type-{{ item.type }}">
                        <a name="atoc_{{ item.id }}"></a>
=======

    {% macro tree(item) %}
        {% import _self as self %}
        <div id="toc_{{ item.id }}"
             class="panel panel-default
                    {{ item.parent_id ? 'child_item':'root_item' }}
                    lp_item_type_{{ item.type|replace({' ': '_'}) }}
                    {{ item.status_css_class_name }}
                    {{ item.is_current ? 'current_item scorm_highlight' : '' }}
                    {{ item.is_parent_of_current ? 'parent_of_current_item' : '' }}
                    {{ item.is_chapter ? 'chapter' : '' }}
                    "
             data-lp-id="{{ item.id }}"
        >
            <div class="status-heading">
                <div id="heading_item_{{item.id}}" class="panel-heading" role="tab">
                    {% if item.children|length %}
                        <a class="item-header" role="button"
                            data-toggle="collapse" data-parent="#tocchildren_{{ item.parent_id }}"
                            href="#tocchildren_{{ item.id }}"
                            aria-expanded="true" aria-controls="tocchildren_{{ item.id }}">
                            {{ item.title }}
                        </a>
                    {% else %}
>>>>>>> 61362f59ef9a2597e75561cb63dbefb136098be0
                        <a data-type="type-{{ item.type }}" class="item-action" href="#"
                           onclick="switch_item('{{ item.current_id }}','{{ item.id }}'); return false;">
                            <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                            {{ item.title }}
                        </a>
<<<<<<< HEAD
                    </div>
                </li>
            {% endif %}
=======
                    {% endif %}
                </div>
            </div>
            {% if item.children|length %}
                <div id="tocchildren_{{ item.id }}"
                     class="panel-collapse collapse {{ item.is_parent_of_current ? 'in' : '' }}"
                     role="tabpanel"
                     aria-labelledby="heading_item_{{item.id}}">
                    <div class="panel-body">
                        {% for child in item.children %}
                            {{ self.tree(child) }}
                        {% endfor %}
                    </div>
                </div>
            {% endif %}
        </div>
    {% endmacro %}

    {% from _self import tree %}
    <div id="tocchildren_" class="panel-group" role="tablist" aria-multiselectable="true">
        {% for item in data_panel %}
            {{ tree(item) }}
>>>>>>> 61362f59ef9a2597e75561cb63dbefb136098be0
        {% endfor %}
        </ul>
    </div>
</div>
{% endif %}