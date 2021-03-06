<script src="{{ system.script_url }}/resource/selectize/0.11.2/js/standalone/selectize.js"></script>
<link rel="stylesheet" href="{{ system.script_url }}/resource/selectize/0.11.2/css/selectize.bootstrap3.css" />
<script>
    var host_url = window.location.href.substring(0, window.location.href.indexOf('/install/'));

    (function( $ ) {
        "use strict";

        $( document ).ready(function() {
            $('.selectize-select').selectize({
                create: false,
                sortField: 'text'
            });
        });

    })( jQuery );
</script>
{% import 'macro/notify.tpl' as ntpl %}
{% if notify.success %}
    {{ ntpl.success(language.install_done_success) }}
    <script>
        location.href = host_url;
    </script>
{% endif %}
{% if notify.prepare %}
    {% if notify.prepare.lock %}
        {{ ntpl.error(language.install_locked) }}
    {% endif %}
    {% if notify.prepare.cfg_write %}
        {{ ntpl.error(language.install_config_notwritable) }}
    {% endif %}
    {% if notify.prepare.inst_write %}
        {{ ntpl.error(language.install_self_notwritable) }}
    {% endif %}
    {% if notify.prepare.sql_notfound %}
        {{ ntpl.error(language.install_sql_not_found) }}
    {% endif %}
{% else %}
    {% if notify.process.db_conn_miss %}
        {{ ntpl.error(language.install_db_wrongcon) }}
    {% endif %}
    {% if notify.process.reg_email_wrong %}
        {{ ntpl.error(language.install_install_error_mail) }}
    {% endif %}
    {% if notify.process.reg_pass_wrong %}
        {{ ntpl.error(language.install_install_error_pass) }}
    {% endif %}
    {% if notify.process.reg_login_wrong %}
        {{ ntpl.error(language.install_install_error_login) }}
    {% endif %}
    {% if notify.process.reg_repass_nomatch %}
        {{ ntpl.error(language.install_install_error_mathcpass) }}
    {% endif %}
    <form class="form-horizontal" method="post" action="" autocomplete="off">
        <h3>{{ language.install_install_db_title }}</h3>
        <div class="form-group has-feedback">
            <label class="control-label col-lg-3">{{ language.install_install_db_host_title }}</label>
            <div class="col-lg-9">
                <input type="text" name="config:db_host" value="{{ cfg.db_host }}" placeholder="localhost" class="form-control input-primary" required="required">
                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                <p class="help-block">{{ language.install_install_db_host_desc }}</p>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label class="control-label col-lg-3">{{ language.install_install_db_user_title }}</label>
            <div class="col-lg-9">
                <input type="text" placeholder="root" name="config:db_user" value="{{ cfg.db_user }}" class="form-control input-primary" required="required">
                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                <p class="help-block">{{ language.install_install_db_user_desc }}</p>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label class="control-label col-lg-3">{{ language.install_install_db_pass_title }}</label>
            <div class="col-lg-9">
                <input type="password" placeholder="Password" name="config:db_pass" value="{{ cfg.db_pass }}" class="form-control input-primary">
                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                <p class="help-block">{{ language.install_install_db_pass_desc }}</p>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label class="control-label col-lg-3">{{ language.install_install_db_name_title }}</label>
            <div class="col-lg-9">
                <input type="text" placeholder="ffcms" name="config:db_name" value="{{ cfg.db_name }}" class="form-control input-primary" required="required">
                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                <p class="help-block">{{ language.install_install_db_name_desc }}</p>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label class="control-label col-lg-3">{{ language.install_install_db_prefix_title }}</label>
            <div class="col-lg-9">
                <input type="text" placeholder="ffcms" name="config:db_prefix" value="{{ cfg.db_prefix|default('ffcms') }}" class="form-control input-primary" required="required">
                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                <p class="help-block">{{ language.install_install_db_prefix_desc }}</p>
            </div>
        </div>
        <h3>{{ language.install_install_main_title }}</h3>
        <div class="form-group">
            <label class="control-label col-lg-3">{{ language.install_install_main_url_title }}</label>
            <div class="col-lg-9">
                <input type="text" placeholder="http://ffcms.ru" name="config:url" value="{{ cfg.url }}" class="form-control" id="hosturl" required="required">
                <p class="help-block">{{ language.install_install_main_url_desc }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{{ language.install_install_main_lang_title }}</label>
            <div class="col-lg-9">
                <select name="config:lang" class="form-control">
                    {% for availablelang in system.lang_available %}
                        <option value="{{ availablelang }}"{% if availablelang == cfg.lang %} selected{% endif %}>{{ availablelang }}</option>
                    {% endfor %}
                </select>
                <p class="help-block">{{ language.install_install_main_lang_desc }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{{ language.install_install_main_timezone_title }}</label>
            <div class="col-lg-9">
                <select name="config:time_zone" class="form-control selectize-select">
                    {% for tz_name,tz_utc in system.timezones %}
                        <option value="{{ tz_name }}"{% if tz_name == cfg.time_zone %} selected{% endif %}>{{ tz_name }}({{ tz_utc }})</option>
                    {% endfor %}
                </select>
                <p class="help-block">{{ language.install_install_main_timezone_desc }}</p>
            </div>
        </div>
    <ul class="nav nav-tabs">
        {% for itemlang in system.languages %}
            <li{% if itemlang == system.lang %} class="active"{% endif %}><a href="#{{ itemlang }}" data-toggle="tab">{{ language.install_switch_language }}: {{ itemlang|upper }}</a></li>
        {% endfor %}
    </ul>
    <br />
    <div class="tab-content">
    {% for itemlang in system.languages %}
        <div class="tab-pane fade{% if itemlang == system.lang %} in active{% endif %}" id="{{ itemlang }}">
            <div class="form-group">
                <label class="control-label col-lg-3">{{ language.install_install_main_seotitle_title }}[{{ itemlang }}]</label>
                <div class="col-lg-9">
                    <input type="text" placeholder="Dart Vader blog" name="config:seo_title[{{ itemlang }}]" value="{{ cfg.seo_title[itemlang] }}" class="form-control"{% if itemlang == system.lang %} required="required" {% endif %}>
                    <p class="help-block">{{ language.install_install_main_seotitle_desc }}</p>
                </div>
            </div>
        </div>
    {% endfor %}
    </div>

        <p class="alert alert-info">{{ language.install_install_main_notifymore }}</p>
        <h3>{{ language.install_install_admin_title }}</h3>
        <div class="form-group">
            <label class="control-label col-lg-3">{{ language.install_install_admin_login_title }}</label>
            <div class="col-lg-9">
                <input type="text" placeholder="admin" name="admin:login" value="{{ cfg.login }}" class="form-control" required="required">
                <p class="help-block">{{ language.install_install_admin_login_desc }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{{ language.install_install_admin_email_title }}</label>
            <div class="col-lg-9">
                <input type="text" placeholder="admin@example.com" name="admin:email" value="{{ cfg.email }}" class="form-control" required="required">
                <p class="help-block">{{ language.install_install_admin_email_desc }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{{ language.install_install_admin_pass_title }}</label>
            <div class="col-lg-9">
                <input type="password" placeholder="StrOnGPas1s4ord" name="admin:pass" class="form-control" required="required">
                <p class="help-block">{{ language.install_install_admin_pass_desc }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{{ language.install_install_admin_repass_title }}</label>
            <div class="col-lg-9">
                <input type="password" placeholder="StrOnGPas1s4ord" name="admin:repass" class="form-control" required="required">
                <p class="help-block">{{ language.install_install_admin_repass_desc }}</p>
            </div>
        </div>
        <p>{{ language.install_install_afteraction_notify }}</p>
        <div class="form-group">
            <label class="col-lg-3 control-label"><a href="../license.txt" target="_blank">license.txt</a></label>
            <div class="col-lg-9"><i class="glyphicon glyphicon-ok"></i> {{ language.install_install_gpl_notify }}</div>
        </div>
        <input type="submit" name="submit" value="{{ language.install_install_button }}" class="btn btn-success" />
    </form>
{% endif %}
<script>
    document.getElementById('hosturl').value = host_url;
</script>