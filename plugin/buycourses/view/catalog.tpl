<link rel="stylesheet" type="text/css" href="../resources/css/style.css"/>

<div id="buy-courses-tabs">
    {% if sessions_are_included %}
        <ul class="nav nav-tabs buy-courses-tabs" role="tablist">
            <li id="buy-courses-tab" class="{{ showing_courses ? 'active' : '' }}" role="presentation">
                <a href="course_catalog.php" aria-controls="buy-courses" role="tab">{{ 'Courses'|get_lang }}</a>
            </li>
            <li id="buy-sessions-tab" class="{{ showing_sessions ? 'active' : '' }}" role="presentation">
                <a href="session_catalog.php" aria-controls="buy-sessions" role="tab">{{ 'Sessions'|get_lang }}</a>
            </li>
            {% if services_are_included %}
                <li id="buy-services-tab" class="{{ showing_services ? 'active' : '' }}" role="presentation">
                    <a href="service_catalog.php" aria-controls="buy-services"
                       role="tab">{{ 'Services'|get_plugin_lang('BuyCoursesPlugin') }}</a>
                </li>
            {% endif %}
        </ul>
    {% endif %}

    <div class="tab-content">
        <div class="tab-pane active" aria-labelledby="buy-sessions-tab" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{ search_filter_form }}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="list-course-buy">
                        {% if showing_courses %}
                            {% for course in courses %}

                                    <article class="items-course">
                                        <div class="items-course-image">
                                            <img alt="{{ course.title }}" class="img-responsive"
                                                 src="{{ course.course_img ? course.course_img : 'session_default.png'|icon() }}">
                                            <div class="price">
                                                {% if course.item.is_international %}
                                                    {{ course.item.price_int_formatted }}
                                                {% else %}
                                                    {{ course.item.total_price_formatted }}
                                                {% endif %}
                                            </div>
                                        </div>
                                        <div class="items-course-info">
                                            <h4 class="title">
                                                <a href="{{ _p.web ~ 'course/' ~ course.id ~ '/about/' }}">{{ course.title }}</a>
                                            </h4>
                                            <ul class="list-unstyled">
                                                {% for teacher in course.teachers %}
                                                    <li><em class="fa fa-user"></em> {{ teacher }}</li>
                                                {% endfor %}
                                            </ul>

                                            {% if course.enrolled.checking == "YES" %}
                                                <div class="alert alert-success">
                                                    <em class="fa fa-check-square-o fa-fw"></em> {{ 'TheUserIsAlreadyRegisteredInTheCourse'|get_plugin_lang('BuyCoursesPlugin') }}
                                                </div>
                                            {% elseif course.enrolled.checking == "NO" %}
                                                <div class="toolbar">
                                                    <a class="btn btn-buy btn-block btn-sm" title=""
                                                       href="{{ _p.web_plugin ~ 'buycourses/src/process.php?' ~ {'i': course.id, 't': 1}|url_encode() }}">
                                                        <em class="fa fa-shopping-cart"></em> {{ 'Buy'|get_plugin_lang('BuyCoursesPlugin') }}
                                                    </a>
                                                </div>
                                            {% elseif course.enrolled.checking == "TMP" %}

                                                {% for sale in course.enrolled.sale %}
                                                    <div class="toolbar">
                                                        {% if sale.payment_type == 4 %}
                                                            <button id="sale-{{ sale.reference }}" data-reference="{{ sale.reference }}" data-user="{{ sale.user_id }}" data-paymenttype="{{ sale.payment_type }}" data-productid="{{ sale.product_id }}" class="cancel_payout_catalog btn btn-buy-cancel">
                                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                                                {{ 'TransbankButton'|get_plugin_lang('BuyCoursesPlugin') }}
                                                            </button>
                                                        {% endif %}
                                                    </div>
                                                    {% if sale.payment_type == 2 %}
                                                        <div class="alert alert-success alert-status">{{ 'TransferFailureMessage'|get_plugin_lang('BuyCoursesPlugin') }}</div>
                                                    {% elseif sale.payment_type == 4 %}
                                                        <div class="alert alert-warning alert-status">{{ 'TransbankFailureMessage'|get_plugin_lang('BuyCoursesPlugin') }}</div>
                                                    {% endif %}

                                                {% endfor %}

                                            {% endif %}
                                        </div>
                                    </article>

                            {% endfor %}
                        {% endif %}

                        {% if showing_sessions %}
                            {% for session in sessions %}

                                    <article class="items-course">
                                        <div class="items-course-image">
                                            <img alt="{{ session.name }}" class="img-responsive"
                                                 src="{{ session.image ? session.image : 'session_default.png'|icon() }}">
                                            <div class="price">
                                                {% if session.item.is_international %}
                                                    {{ session.item.price_usd }}
                                                {% else %}
                                                    {{ session.item.total_price_formatted }}
                                                {% endif %}
                                            </div>
                                        </div>
                                        <div class="items-course-info">
                                            <h4 class="title">
                                                <a href="{{ _p.web ~ 'session/' ~ session.id ~ '/about/' }}">{{ session.name }}</a>
                                            </h4>
                                            {% if 'show_session_coach'|api_get_setting == 'true' %}
                                                <p><em class="fa fa-user fa-fw"></em> {{ session.coach }}</p>
                                            {% endif %}
                                            <p><em class="fa fa-calendar fa-fw"></em> {{ session.dates.display }}</p>
                                            {% if session.enrolled.checking == "YES" %}
                                                <div class="alert alert-success">
                                                    <em class="fa fa-check-square-o fa-fw"></em> {{ 'TheUserIsAlreadyRegisteredInTheSession'|get_plugin_lang('BuyCoursesPlugin') }}
                                                </div>
                                            {% elseif session.enrolled.checking == "NO" %}
                                                <div class="toolbar">
                                                    <a class="btn btn-buy btn-block btn-sm"
                                                       href="{{ _p.web_plugin ~ 'buycourses/src/process.php?' ~ {'i': session.id, 't': 2}|url_encode() }}">
                                                        <em class="fa fa-shopping-cart"></em> {{ 'Buy'|get_plugin_lang('BuyCoursesPlugin') }}
                                                    </a>
                                                </div>
                                            {% elseif session.enrolled.checking == "TMP" %}
                                                {% for sale in session.enrolled.sale %}
                                                    <div class="toolbar">
                                                        {% if sale.payment_type == 4 %}
                                                            <button id="sale-{{ sale.reference }}" data-reference="{{ sale.reference }}" data-user="{{ sale.user_id }}" data-paymenttype="{{ sale.payment_type }}" data-productid="{{ sale.product_id }}" class="cancel_payout_catalog btn btn-buy-cancel">
                                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                                                {{ 'TransbankButton'|get_plugin_lang('BuyCoursesPlugin') }}
                                                            </button>
                                                        {% endif %}
                                                    </div>
                                                    {% if sale.payment_type == 2 %}
                                                        <div class="alert alert-success alert-status">{{ 'TransferFailureMessage'|get_plugin_lang('BuyCoursesPlugin') }}</div>
                                                    {% elseif sale.payment_type == 4 %}
                                                        <div class="alert alert-warning alert-status">{{ 'TransbankFailureMessage'|get_plugin_lang('BuyCoursesPlugin') }}</div>
                                                    {% endif %}
                                                {% endfor %}

                                            {% endif %}
                                        </div>
                                    </article>

                            {% endfor %}
                        {% endif %}

                        {% if showing_services %}
                            {% for service in services %}
                                <div class="col-md-4 col-sm-6">
                                    <div class="items-course">
                                        <div class="items-course-image">
                                            <a href="{{ _p.web }}service/{{ service.id }}">
                                                <img alt="{{ service.name }}"
                                                    class="img-responsive"
                                                    src="{{ service.image ? service.image : 'session_default.png'|icon() }}"></a>
                                        </div>
                                        <div class="items-course-info">
                                            <h4 class="title">
                                                <a title="{{ service.name }}"
                                                   href="{{ _p.web }}service/{{ service.id }}">
                                                    {{ service.name }}
                                                </a>
                                            </h4>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <em class="fa fa-clock-o"></em> {{ 'Duration'|get_plugin_lang('BuyCoursesPlugin') }}
                                                    : {{ service.duration_days == 0 ? 'NoLimit'|get_lang  : service.duration_days ~ ' ' ~ 'Days'|get_lang }}
                                                </li>
                                                {% if service.applies_to == 0 %}
                                                    <li>
                                                        <em class="fa fa-hand-o-right"></em> {{ 'AppliesTo'|get_plugin_lang('BuyCoursesPlugin') }} {{ 'None'|get_lang }}
                                                    </li>
                                                {% elseif service.applies_to == 1 %}
                                                    <li>
                                                        <em class="fa fa-hand-o-right"></em> {{ 'AppliesTo'|get_plugin_lang('BuyCoursesPlugin') }} {{ 'User'|get_lang }}
                                                    </li>
                                                {% elseif service.applies_to == 2 %}
                                                    <li>
                                                        <em class="fa fa-hand-o-right"></em> {{ 'AppliesTo'|get_plugin_lang('BuyCoursesPlugin') }} {{ 'Course'|get_lang }}
                                                    </li>
                                                {% elseif service.applies_to == 3 %}
                                                    <li>
                                                        <em class="fa fa-hand-o-right"></em> {{ 'AppliesTo'|get_plugin_lang('BuyCoursesPlugin') }} {{ 'Session'|get_lang }}
                                                    </li>
                                                {% elseif service.applies_to == 4 %}
                                                    <li>
                                                        <em class="fa fa-hand-o-right"></em> {{ 'AppliesTo'|get_plugin_lang('BuyCoursesPlugin') }} {{ 'TemplateTitleCertificate'|get_plugin_lang('BuyCoursesPlugin') }}
                                                    </li>
                                                {% endif %}
                                                <li><em class="fa fa-user"></em> {{ service.owner_name }}</li>
                                            </ul>
                                            <p class="text-right">
                                                <span class="label label-primary">
                                                     {{ service.total_price_formatted }}
                                                </span>
                                            </p>
                                            <div class="toolbar">
                                                <a class="btn btn-info btn-block btn-sm" title=""
                                                   href="{{ _p.web }}service/{{ service.id }}">
                                                    <em class="fa fa-info-circle"></em> {{ 'ServiceInformation'|get_plugin_lang('BuyCoursesPlugin') }}
                                                </a>
                                                <a class="btn btn-success btn-block btn-sm" title=""
                                                   href="{{ _p.web_plugin ~ 'buycourses/src/service_process.php?' ~ {'i': service.id, 't': service.applies_to}|url_encode() }}">
                                                    <em class="fa fa-shopping-cart"></em> {{ 'Buy'|get_plugin_lang('BuyCoursesPlugin') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        {% endif %}
                        </div>
                    </div>
                    {{ pagination }}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".cancel_payout_catalog").click(function () {
            var reference = $(this).data("reference");
            var user = $(this).data("user");
            $.ajax({
                data: { 'reference' : reference, 'user': user },
                url: '{{ _p.web_plugin ~ 'buycourses/src/buycourses.ajax.php?' ~  { 'a': 'cancel_payment_reference' }|url_encode() }}',
                type: 'POST',
                success: function () {
                    window.location.reload();
                }
            });
        });
    });
</script>
