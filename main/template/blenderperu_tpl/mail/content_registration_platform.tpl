<p>{{ 'helloUser'|get_lang }} <strong>{{ name }}</strong>, {{ 'howAreYour'|get_lang }}</p>
<p>{{ 'textWelcome'|get_lang }}</p>
<p>{{ 'accessCredentials'|get_lang }}</p>
<div style="padding: 20px; background-color: #e5eaff;">
    {{ 'linkPlataform'|get_lang }}: {{ mailWebPath }}<br>
    {{ 'userNameEmail'|get_lang }} : {{ login_name }}<br>
    {{ 'Pass'|get_lang }} : {{ original_password }}
</div>
<p>
    {{ 'technicalSupport'|get_lang }} {{ _admin.email }}
</p>
<p>
    {{ 'regardsEducaChile'|get_lang }}
</p>