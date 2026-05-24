{\rtf1\ansi\ansicpg1252\cocoartf2867
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\paperw11900\paperh16840\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0 <?php\
/**\
 * Plugin Name: Lead to Sale Tracker - Enterprise Pro\
 * Description: \uc0\u1606 \u1587 \u1582 \u1607  \u1578 \u1580 \u1575 \u1585 \u1740  \u1662 \u1740 \u1588 \u1585 \u1601 \u1578 \u1607  \u1576 \u1575  \u1602 \u1575 \u1576 \u1604 \u1740 \u1578  \u1605 \u1583 \u1740 \u1585 \u1740 \u1578  \u1583 \u1575 \u1740 \u1606 \u1575 \u1605 \u1740 \u1705  \u1587 \u1578 \u1608 \u1606 \u8204 \u1607 \u1575 \u1548  \u1582 \u1585 \u1608 \u1580 \u1740  \u1578 \u1601 \u1705 \u1740 \u1705 \u8204 \u1588 \u1583 \u1607  \u1575 \u1705 \u1587 \u1604 \u1548  \u1586 \u1605 \u1575 \u1606 \u8204 \u1587 \u1606 \u1580  \u1585 \u1740 \u1575 \u1590 \u1740  \u1779 :\u1779 \u1776 + \u1711 \u1585 \u1740 \u1606 \u1608 \u1740 \u1670 \u1548  \u1601 \u1740 \u1604 \u1578 \u1585  \u1575 \u1740 \u1605 \u1606  \u1604 \u1740 \u1583 \u1607 \u1575 \u1740  \u1587 \u1740 \u1587 \u1578 \u1605 \u1740  \u1575 \u1583 \u1605 \u1740 \u1606  \u1608  \u1601 \u1740 \u1604 \u1578 \u1585 \u1575 \u1587 \u1740 \u1608 \u1606  \u1662 \u1740 \u1588 \u1585 \u1601 \u1578 \u1607  \u1578 \u1575 \u1585 \u1740 \u1582  (\u1576 \u1583 \u1608 \u1606  \u1605 \u1575 \u1688 \u1608 \u1604  \u1602 \u1740 \u1605 \u1578  \u1601 \u1585 \u1608 \u1588 ).\
 * Version: 7.5.0\
 * Author: Amirabbas Alavi\
 * Text Domain: lead-tracker\
 * Requires at least: 5.8\
 * Requires PHP: 7.4\
 */\
\
if (!defined('ABSPATH')) \{\
    exit;\
\}\
\
// \uc0\u1777 . \u1587 \u1575 \u1582 \u1578  \u1608  \u1576 \u1575 \u1586 \u1587 \u1575 \u1586 \u1740  \u1583 \u1740 \u1578 \u1575 \u1576 \u1740 \u1587  (\u1576 \u1583 \u1608 \u1606  \u1601 \u1740 \u1604 \u1583  \u1602 \u1740 \u1605 \u1578 )\
register_activation_hook(__FILE__, 'lts_enterprise_activate_v750');\
function lts_enterprise_activate_v750() \{\
    global $wpdb;\
    $table_name = $wpdb->prefix . 'lts_leads';\
    $charset_collate = $wpdb->get_charset_collate();\
    \
    $wpdb->query("DROP TABLE IF EXISTS $table_name");\
\
    $sql = "CREATE TABLE $table_name (\
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,\
        form_data longtext DEFAULT NULL,\
        utm_source varchar(255) DEFAULT NULL,\
        utm_medium varchar(255) DEFAULT NULL,\
        utm_campaign varchar(255) DEFAULT NULL,\
        utm_term varchar(255) DEFAULT NULL,\
        utm_content varchar(255) DEFAULT NULL,\
        gclid varchar(255) DEFAULT NULL,\
        landing_page varchar(512) DEFAULT NULL,\
        form_page varchar(512) DEFAULT NULL,\
        status varchar(50) DEFAULT 'pending',\
        unique_hash varchar(255) DEFAULT NULL,\
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,\
        PRIMARY KEY (id),\
        UNIQUE KEY unique_hash (unique_hash)\
    ) $charset_collate;";\
    \
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');\
    dbDelta($sql);\
\}\
\
// \uc0\u1778 . \u1584 \u1582 \u1740 \u1585 \u1607  \u1662 \u1575 \u1740 \u1583 \u1575 \u1585  \u1705 \u1608 \u1705 \u1740 \u8204 \u1607 \u1575 \u1740  \u1605 \u1575 \u1585 \u1705 \u1578 \u1740 \u1606 \u1711  \u1583 \u1585  \u1601 \u1585 \u1575 \u1606 \u1578 \u8204 \u1575 \u1606 \u1583 \
add_action('wp_head', 'lts_enterprise_frontend_script_v750');\
function lts_enterprise_frontend_script_v750() \{\
    ?>\
    <script type="text/javascript">\
    (function() \{\
        function setCookie(name, value, days) \{\
            var expires = "";\
            if (days) \{\
                var date = new Date();\
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));\
                expires = "; expires=" + date.toUTCString();\
            \}\
            document.cookie = name + "=" + encodeURIComponent(value || "") + expires + "; path=/; SameSite=Lax";\
        \}\
        function getCookie(name) \{\
            var nameEQ = name + "=";\
            var ca = document.cookie.split(';');\
            for(var i=0;i < ca.length;i++) \{\
                var c = ca[i];\
                while (c.charAt(0)==' ') c = c.substring(1,c.length);\
                if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length,c.length));\
            \}\
            return null;\
        \}\
        var urlParams = new URLSearchParams(window.location.search);\
        var params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid'];\
        params.forEach(function(param) \{\
            var val = urlParams.get(param);\
            if (val) setCookie('lts_' + param, val, 30);\
        \});\
        if (!getCookie('lts_landing_page')) \{\
            setCookie('lts_landing_page', window.location.href, 30);\
        \}\
    \})();\
    </script>\
    <?php\
\}\
\
// \uc0\u1779 . \u55356 \u57263  \u1588 \u1606 \u1608 \u1583  \u1607 \u1608 \u1588 \u1605 \u1606 \u1583  \u1608  \u1575 \u1740 \u1605 \u1606  \u1604 \u1740 \u1583 \u1607 \u1575  \u1576 \u1583 \u1608 \u1606  \u1578 \u1583 \u1575 \u1582 \u1604  \u1576 \u1575  \u1601 \u1585 \u1575 \u1606 \u1578 \u8204 \u1575 \u1606 \u1606 \u1583 \
add_action('plugins_loaded', 'lts_enterprise_request_catcher_v750');\
function lts_enterprise_request_catcher_v750() \{\
    if (empty($_POST) || !is_array($_POST)) \{\
        return;\
    \}\
\
    $referrer_uri = $_SERVER['HTTP_REFERER'] ?? '';\
\
    if (!empty($referrer_uri)) \{\
        if (strpos($referrer_uri, 'wp-admin/') !== false && strpos($referrer_uri, 'admin-ajax.php') === false) \{\
            return;\
        \}\
        if (strpos($referrer_uri, 'wp-login.php') !== false) \{\
            return;\
        \}\
    \}\
\
    global $wpdb;\
    $table_name = $wpdb->prefix . 'lts_leads';\
\
    $clean_form_data = [];\
    $total_chars_count = 0; \
    \
    $discovered_fields = get_option('lts_discovered_fields', array());\
    if (!is_array($discovered_fields)) \{ $discovered_fields = array(); \}\
\
    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($_POST));\
    foreach ($iterator as $key => $val) \{\
        $key_str = trim(strval($key));\
        $val_str = trim(strval($val));\
        $key_lower = strtolower($key_str);\
\
        if ($val_str === '' || strlen($val_str) > 3000 || \
            strpos($key_str, '_wpcf7') === 0 || strpos($key_str, 'action') === 0 || \
            strpos($key_str, 'ak_') === 0 || $key_str === 'nonce' || \
            strpos($key_lower, 'password') !== false || strpos($key_lower, 'captcha') !== false ||\
            strpos($key_lower, 'wp_http_referer') !== false || strpos($key_str, '_wpnonce') === 0 ||\
            strpos($key_str, 'plugin') !== false || strpos($key_str, 'checked') !== false) \{\
            continue;\
        \}\
\
        $sanitized_key = sanitize_text_field($key_str);\
        $sanitized_val = sanitize_text_field($val_str);\
        \
        $clean_form_data[$sanitized_key] = $sanitized_val;\
        $total_chars_count += strlen($sanitized_val); \
    \}\
\
    if (empty($clean_form_data) || $total_chars_count === 0 || count($clean_form_data) < 1) \{\
        return;\
    \}\
\
    add_action('wp', function() use ($clean_form_data) \{\
        if (current_user_can('manage_options')) \{\
            return; \
        \}\
    \});\
\
    foreach ($clean_form_data as $sanitized_key => $v) \{\
        if (!in_array($sanitized_key, $discovered_fields)) \{\
            $discovered_fields[] = $sanitized_key;\
        \}\
    \}\
    update_option('lts_discovered_fields', $discovered_fields);\
\
    // \uc0\u55357 \u56658  \u1605 \u1581 \u1575 \u1587 \u1576 \u1607  \u1585 \u1740 \u1575 \u1590 \u1740  \u1587 \u1575 \u1593 \u1578  \u1576 \u1575  \u1601 \u1585 \u1605 \u1608 \u1604  \u1779 :\u1779 \u1776 + \u1711 \u1585 \u1740 \u1606 \u1608 \u1740 \u1670 \
    $utc_timestamp = time(); \
    $iran_offset = (3 * 3600) + (30 * 60); \
    $current_local_time = gmdate('Y-m-d H:i:s', $utc_timestamp + $iran_offset);\
\
    $unique_hash = md5(json_encode($clean_form_data, JSON_UNESCAPED_UNICODE));\
\
    $utm_source   = $_GET['utm_source']   ?? ($_POST['utm_source']   ?? ($_COOKIE['lts_utm_source']   ?? ''));\
    $utm_medium   = $_GET['utm_medium']   ?? ($_POST['utm_medium']   ?? ($_COOKIE['lts_utm_medium']   ?? ''));\
    $utm_campaign = $_GET['utm_campaign'] ?? ($_POST['utm_campaign'] ?? ($_COOKIE['lts_utm_campaign'] ?? ''));\
    $utm_term     = $_GET['utm_term']     ?? ($_POST['utm_term']     ?? ($_COOKIE['lts_utm_term']     ?? ''));\
    $utm_content  = $_GET['utm_content']  ?? ($_POST['utm_content']  ?? ($_COOKIE['lts_utm_content']  ?? ''));\
    $gclid        = $_GET['gclid']        ?? ($_POST['gclid']        ?? ($_COOKIE['lts_gclid']        ?? ''));\
    $landing_page = $_COOKIE['lts_landing_page'] ?? ($referrer_uri ?: home_url('/'));\
\
    $wpdb->query(\
        $wpdb->prepare(\
            "INSERT IGNORE INTO $table_name \
            (form_data, utm_source, utm_medium, utm_campaign, utm_term, utm_content, gclid, landing_page, form_page, status, unique_hash, created_at) \
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",\
            json_encode($clean_form_data, JSON_UNESCAPED_UNICODE),\
            sanitize_text_field(urldecode($utm_source)),\
            sanitize_text_field(urldecode($utm_medium)),\
            sanitize_text_field(urldecode($utm_campaign)),\
            sanitize_text_field(urldecode($utm_term)),\
            sanitize_text_field(urldecode($utm_content)),\
            sanitize_text_field(urldecode($gclid)),\
            esc_url_raw(urldecode($landing_page)),\
            esc_url_raw($referrer_uri),\
            'pending',\
            $unique_hash,\
            $current_local_time\
        )\
    );\
\}\
\
// \uc0\u55357 \u56787 \u65039  \u1578 \u1575 \u1576 \u1593  \u1605 \u1576 \u1583 \u1604  \u1578 \u1575 \u1585 \u1740 \u1582  \u1580 \u1604 \u1575 \u1604 \u1740  \u1605 \u1606 \u1591 \u1576 \u1602  \u1576 \u1585  \u1587 \u1575 \u1593 \u1578  \u1583 \u1740 \u1578 \u1575 \u1576 \u1740 \u1587 \
function lts_get_jalali_date_v750($mysql_date) \{\
    if (empty($mysql_date)) return '-';\
    $timestamp = strtotime($mysql_date);\
    \
    if (class_exists('IntlDateFormatter')) \{\
        $formatter = new IntlDateFormatter(\
            'fa_IR@calendar=persian',\
            IntlDateFormatter::MEDIUM,\
            IntlDateFormatter::SHORT,\
            'UTC', \
            IntlDateFormatter::TRADITIONAL\
        );\
        return $formatter->format($timestamp);\
    \}\
    \
    return date('Y-m-d H:i', $timestamp);\
\}\
\
// \uc0\u1780 . \u1575 \u1740 \u1580 \u1575 \u1583  \u1605 \u1606 \u1608 \u1607 \u1575  \u1583 \u1585  \u1587 \u1575 \u1740 \u1583 \u1576 \u1575 \u1585  \u1605 \u1583 \u1740 \u1585 \u1740 \u1578  \u1608 \u1585 \u1583 \u1662 \u1585 \u1587 \
add_action('admin_menu', 'lts_enterprise_menus_v750');\
function lts_enterprise_menus_v750() \{\
    add_menu_page('\uc0\u1604 \u1740 \u1583 \u1607 \u1575 ', '\u1604 \u1740 \u1583 \u1607 \u1575 ', 'read', 'lead-tracker', 'lts_render_leads_page_v750', 'dashicons-id-alt', 25);\
    add_submenu_page('lead-tracker', '\uc0\u1578 \u1606 \u1592 \u1740 \u1605 \u1575 \u1578  \u1587 \u1578 \u1608 \u1606 \u8204 \u1607 \u1575 ', '\u9881 \u65039  \u1578 \u1606 \u1592 \u1740 \u1605 \u1575 \u1578  \u1587 \u1578 \u1608 \u1606 \u8204 \u1607 \u1575 ', 'manage_options', 'lts-column-settings', 'lts_render_column_settings_page_v750');\
    add_submenu_page('lead-tracker', '\uc0\u1711 \u1586 \u1575 \u1585 \u1588  \u1705 \u1605 \u1662 \u1740 \u1606 \u8204 \u1607 \u1575 ', '\u1711 \u1586 \u1575 \u1585 \u1588  \u1705 \u1605 \u1662 \u1740 \u1606 \u8204 \u1607 \u1575 ', 'read', 'lts-reports', 'lts_render_reports_page_v750');\
\}\
\
// \uc0\u1578 \u1606 \u1592 \u1740 \u1605 \u1575 \u1578  \u1587 \u1578 \u1608 \u1606 \u8204 \u1607 \u1575 \u1740  \u1583 \u1575 \u1740 \u1606 \u1575 \u1605 \u1740 \u1705  \u1662 \u1740 \u1588 \u1582 \u1608 \u1575 \u1606 \
function lts_render_column_settings_page_v750() \{\
    if (!current_user_can('manage_options')) \{ return; \}\
\
    if (isset($_POST['lts_save_columns_nonce']) && wp_verify_nonce($_POST['lts_save_columns_nonce'], 'lts_save_columns_action')) \{\
        $selected_cols = isset($_POST['visible_cols']) ? array_map('sanitize_text_field', $_POST['visible_cols']) : array();\
        if (count($selected_cols) > 4) \{\
            echo '<div class="notice notice-error is-dismissible"><p>\uc0\u1582 \u1591 \u1575 : \u1581 \u1583 \u1575 \u1705 \u1579 \u1585  \u1605 \u1580 \u1575 \u1586  \u1576 \u1607  \u1575 \u1606 \u1578 \u1582 \u1575 \u1576  \u1780  \u1601 \u1740 \u1604 \u1583  \u1607 \u1587 \u1578 \u1740 \u1583 .</p></div>';\
        \} else \{\
            update_option('lts_visible_columns', $selected_cols);\
            echo '<div class="notice notice-success is-dismissible"><p>\uc0\u1578 \u1606 \u1592 \u1740 \u1605 \u1575 \u1578  \u1606 \u1605 \u1575 \u1740 \u1588  \u1587 \u1578 \u1608 \u1606 \u8204 \u1607 \u1575  \u1576 \u1575  \u1605 \u1608 \u1601 \u1602 \u1740 \u1578  \u1584 \u1582 \u1740 \u1585 \u1607  \u1588 \u1583 .</p></div>';\
        \}\
    \}\
\
    $discovered_fields = get_option('lts_discovered_fields', array());\
    $visible_columns = get_option('lts_visible_columns', array());\
    ?>\
    <div class="wrap" style="direction: rtl; font-family: Tahoma, sans-serif; max-width: 900px; margin-top: 25px;">\
        <h1 style="font-weight: bold; font-size: 22px; color: #1d2327; margin-bottom: 20px;">\uc0\u1578 \u1606 \u1592 \u1740 \u1605 \u1575 \u1578  \u1606 \u1605 \u1575 \u1740 \u1588  \u1601 \u1740 \u1604 \u1583 \u1607 \u1575  \u1583 \u1585  \u1662 \u1740 \u1588 \u1582 \u1608 \u1575 \u1606 </h1>\
        <div style="background: #fff; border: 1px solid #c3c4c7; box-shadow: 0 1px 15px rgba(0,0,0,0.04); border-radius: 8px; padding: 25px;">\
            <form method="post">\
                <?php wp_nonce_field('lts_save_columns_action', 'lts_save_columns_nonce'); ?>\
                <?php if (empty($discovered_fields)) : ?>\
                    <div style="padding: 30px; text-align: center; background: #f0f0f1; border-radius: 6px; border: 1px dashed #c3c4c7;">\
                        <p style="font-weight: bold; margin: 0; color: #50575e;">\uc0\u1607 \u1606 \u1608 \u1586  \u1607 \u1740 \u1670  \u1601 \u1585 \u1605  \u1605 \u1593 \u1578 \u1576 \u1585 \u1740  \u1575 \u1585 \u1587 \u1575 \u1604  \u1606 \u1588 \u1583 \u1607  \u1575 \u1587 \u1578 .</p>\
                    </div>\
                <?php else : ?>\
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">\
                        <?php foreach ($discovered_fields as $field) : \
                            $is_checked = in_array($field, $visible_columns) ? 'checked' : '';\
                            ?>\
                            <label style="background: #f8f9fa; border: 1px solid #dcdcde; border-radius: 6px; padding: 12px 15px; display: flex; align-items: center; cursor: pointer;">\
                                <input type="checkbox" name="visible_cols[]" value="<?php echo esc_attr($field); ?>" <?php echo $is_checked; ?> style="margin-left: 10px; transform: scale(1.15);">\
                                <span style="font-family: monospace; font-size: 13px; color: #2c3338; word-break: break-all;"><?php echo esc_html($field); ?></span>\
                            </label>\
                        <?php endforeach; ?>\
                    </div>\
                    <hr style="border: 0; border-top: 1px solid #f0f0f1; margin: 20px 0;">\
                    <button type="submit" class="button button-primary button-large" style="height: 40px; padding: 0 25px; font-weight: bold;">\uc0\u1584 \u1582 \u1740 \u1585 \u1607  \u1662 \u1740 \u1705 \u1585 \u1576 \u1606 \u1583 \u1740  \u1587 \u1578 \u1608 \u1606 \u8204 \u1607 \u1575 </button>\
                <?php endif; ?>\
            </form>\
        </div>\
    </div>\
    <?php\
\}\
\
// \uc0\u1580 \u1583 \u1608 \u1604  \u1662 \u1740 \u1588 \u1582 \u1608 \u1575 \u1606  \u1575 \u1589 \u1604 \u1740  \u1606 \u1605 \u1575 \u1740 \u1588  \u1604 \u1740 \u1583 \u1607 \u1575  \u1605 \u1580 \u1607 \u1586  \u1576 \u1607  \u1601 \u1740 \u1604 \u1578 \u1585  \u1576 \u1575 \u1586 \u1607  \u1586 \u1605 \u1575 \u1606 \u1740 \
function lts_render_leads_page_v750() \{\
    if (!current_user_can('read')) \{ return; \}\
    global $wpdb;\
    $table_name = $wpdb->prefix . 'lts_leads';\
\
    $campaign_filter = isset($_GET['campaign_filter']) ? sanitize_text_field($_GET['campaign_filter']) : '';\
    $status_filter = isset($_GET['status_filter']) ? sanitize_text_field($_GET['status_filter']) : '';\
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';\
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';\
\
    $where = " WHERE 1=1";\
    if (!empty($campaign_filter)) $where .= $wpdb->prepare(" AND utm_campaign = %s", $campaign_filter);\
    if (!empty($status_filter)) $where .= $wpdb->prepare(" AND status = %s", $status_filter);\
    if (!empty($start_date)) $where .= $wpdb->prepare(" AND created_at >= %s", $start_date . ' 00:00:00');\
    if (!empty($end_date)) $where .= $wpdb->prepare(" AND created_at <= %s", $end_date . ' 23:59:59');\
\
    $leads = $wpdb->get_results("SELECT * FROM $table_name $where ORDER BY id DESC");\
    $campaigns = $wpdb->get_col("SELECT DISTINCT utm_campaign FROM $table_name WHERE utm_campaign IS NOT NULL AND utm_campaign != ''");\
\
    $visible_columns = get_option('lts_visible_columns', array());\
    $discovered_fields = get_option('lts_discovered_fields', array());\
\
    if (empty($visible_columns) && !empty($discovered_fields)) \{\
        $visible_columns = array_slice($discovered_fields, 0, 3);\
    \}\
\
    $export_url = add_query_arg(array(\
        'action' => 'lts_export_csv_v750', \
        'campaign_filter' => $campaign_filter, \
        'status_filter' => $status_filter,\
        'start_date' => $start_date,\
        'end_date' => $end_date\
    ), admin_url('admin.php'));\
    ?>\
    <div class="wrap" style="direction: rtl;">\
        <h1 class="wp-heading-inline">\uc0\u1605 \u1583 \u1740 \u1585 \u1740 \u1578  \u1604 \u1740 \u1583 \u1607 \u1575 \u1740  \u1608 \u1585 \u1608 \u1583 \u1740  \u1570 \u1688 \u1575 \u1606 \u1587 </h1>\
        <a href="<?php echo esc_url($export_url); ?>" class="page-title-action">\uc0\u1582 \u1585 \u1608 \u1580 \u1740  \u1575 \u1705 \u1587 \u1604  \u1601 \u1740 \u1604 \u1578 \u1585  \u1588 \u1583 \u1607  (CSV)</a>\
        <a href="<?php echo esc_url(admin_url('admin.php?page=lts-column-settings')); ?>" class="page-title-action" style="background:#f6f7f7; color:#0071a1; border-color:#0071a1;">\uc0\u9881 \u65039  \u1578 \u1606 \u1592 \u1740 \u1605  \u1606 \u1605 \u1575 \u1740  \u1587 \u1578 \u1608 \u1606 \u8204 \u1607 \u1575 </a>\
        <hr class="wp-header-end">\
\
        <form method="get" style="margin: 20px 0; background: #fff; border: 1px solid #c3c4c7; padding: 15px; border-radius: 6px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">\
            <input type="hidden" name="page" value="lead-tracker">\
            \
            <div>\
                <label style="display:block; margin-bottom:4px; font-weight:bold; font-size:12px;">\uc0\u1705 \u1605 \u1662 \u1740 \u1606 :</label>\
                <select name="campaign_filter" style="min-width:140px;">\
                    <option value="">\uc0\u1607 \u1605 \u1607  \u1705 \u1605 \u1662 \u1740 \u1606 \u8204 \u1607 \u1575 </option>\
                    <?php foreach ($campaigns as $camp) echo "<option value='".esc_attr($camp)."' ".selected($campaign_filter, $camp, false).">".esc_html($camp)."</option>"; ?>\
                </select>\
            </div>\
\
            <div>\
                <label style="display:block; margin-bottom:4px; font-weight:bold; font-size:12px;">\uc0\u1608 \u1590 \u1593 \u1740 \u1578  \u1605 \u1575 \u1604 \u1740 :</label>\
                <select name="status_filter" style="min-width:130px;">\
                    <option value="">\uc0\u1607 \u1605 \u1607  \u1608 \u1590 \u1593 \u1740 \u1578 \u8204 \u1607 \u1575 </option>\
                    <option value="pending" <?php selected($status_filter, 'pending'); ?>>\uc0\u1583 \u1585  \u1575 \u1606 \u1578 \u1592 \u1575 \u1585  \u1576 \u1585 \u1585 \u1587 \u1740 </option>\
                    <option value="sold" <?php selected($status_filter, 'sold'); ?>>\uc0\u9989  \u1601 \u1585 \u1608 \u1588  \u1588 \u1583 </option>\
                    <option value="rejected" <?php selected($status_filter, 'rejected'); ?>>\uc0\u10060  \u1604 \u1740 \u1583  \u1576 \u1740 \u8204 \u1705 \u1740 \u1601 \u1740 \u1578  (\u1585 \u1583  \u1588 \u1583 )</option>\
                </select>\
            </div>\
\
            <div>\
                <label style="display:block; margin-bottom:4px; font-weight:bold; font-size:12px;">\uc0\u1575 \u1586  \u1578 \u1575 \u1585 \u1740 \u1582 :</label>\
                <input type="date" name="start_date" value="<?php echo esc_attr($start_date); ?>" style="line-height: 1.4;">\
            </div>\
\
            <div>\
                <label style="display:block; margin-bottom:4px; font-weight:bold; font-size:12px;">\uc0\u1578 \u1575  \u1578 \u1575 \u1585 \u1740 \u1582 :</label>\
                <input type="date" name="end_date" value="<?php echo esc_attr($end_date); ?>" style="line-height: 1.4;">\
            </div>\
\
            <div style="padding-top: 18px;">\
                <button type="submit" class="button button-primary">\uc0\u1575 \u1593 \u1605 \u1575 \u1604  \u1601 \u1740 \u1604 \u1578 \u1585  \u1662 \u1740 \u1588 \u1585 \u1601 \u1578 \u1607 </button>\
                <?php if(!empty($campaign_filter) || !empty($status_filter) || !empty($start_date) || !empty($end_date)): ?>\
                    <a href="admin.php?page=lead-tracker" class="button button-link" style="color:#d63638;">\uc0\u1581 \u1584 \u1601  \u1601 \u1740 \u1604 \u1578 \u1585 \u1607 \u1575 </a>\
                <?php endif; ?>\
            </div>\
        </form>\
\
        <table class="wp-list-table widefat fixed striped">\
            <thead>\
                <tr>\
                    <?php if (empty($visible_columns)) : ?>\
                        <th>\uc0\u1605 \u1581 \u1578 \u1608 \u1575 \u1740  \u1601 \u1585 \u1605  \u1575 \u1585 \u1587 \u1575 \u1604 \u1740 </th>\
                    <?php else : ?>\
                        <?php foreach ($visible_columns as $col_key) : ?>\
                            <th>\uc0\u1601 \u1740 \u1604 \u1583  (<?php echo esc_html($col_key); ?>)</th>\
                        <?php endforeach; ?>\
                    <?php endif; ?>\
                    <th style="width: 18%;">\uc0\u1575 \u1591 \u1604 \u1575 \u1593 \u1575 \u1578  \u1605 \u1575 \u1585 \u1705 \u1578 \u1740 \u1606 \u1711  (UTM)</th>\
                    <th style="width: 15%;">\uc0\u1605 \u1587 \u1740 \u1585  \u1589 \u1601 \u1581 \u1575 \u1578  (URI)</th>\
                    <th style="width: 15%;">\uc0\u1578 \u1575 \u1585 \u1740 \u1582  \u1579 \u1576 \u1578  (\u1578 \u1607 \u1585 \u1575 \u1606 )</th>\
                    <th style="width: 8%;">\uc0\u1608 \u1590 \u1593 \u1740 \u1578 </th>\
                    <th style="width: 8%;">\uc0\u1593 \u1605 \u1604 \u1740 \u1575 \u1578 </th>\
                </tr>\
            </thead>\
            <tbody>\
                <?php if (empty($leads)) \{ echo '<tr><td colspan="7">\uc0\u1607 \u1740 \u1670  \u1604 \u1740 \u1583 \u1740  \u1740 \u1575 \u1601 \u1578  \u1606 \u1588 \u1583 .</td></tr>'; \} else \{\
                foreach ($leads as $lead) \{ \
                    $data_array = json_decode($lead->form_data, true);\
                    if (!is_array($data_array)) \{ $data_array = array(); \}\
                    \
                    $landing_uri = !empty($lead->landing_page) ? parse_url($lead->landing_page, PHP_URL_PATH) : '/';\
                    $form_uri = !empty($lead->form_page) ? parse_url($lead->form_page, PHP_URL_PATH) : '/';\
                    if(!empty($lead->landing_page) && parse_url($lead->landing_page, PHP_URL_QUERY)) \{ $landing_uri .= '?' . parse_url($lead->landing_page, PHP_URL_QUERY); \}\
                    ?>\
                    <tr id="lead-row-<?php echo $lead->id; ?>">\
                        <?php if (empty($visible_columns)) : ?>\
                            <td><small style="color:#666;"><?php echo esc_html(mb_strimwidth(json_encode($data_array, JSON_UNESCAPED_UNICODE), 0, 80, '...')); ?></small></td>\
                        <?php else : ?>\
                            <?php foreach ($visible_columns as $col_key) : \
                                $cell_val = isset($data_array[$col_key]) ? $data_array[$col_key] : '-';\
                                ?>\
                                <td><strong><?php echo esc_html($cell_val); ?></strong></td>\
                            <?php endforeach; ?>\
                        <?php endif; ?>\
                        \
                        <td>\
                            <div style="font-size:11px; line-height:1.5; font-family:monospace;">\
                                <strong>Source:</strong> <?php echo esc_html($lead->utm_source ? $lead->utm_source : '-'); ?><br>\
                                <strong>Medium:</strong> <?php echo esc_html($lead->utm_medium ? $lead->utm_medium : '-'); ?><br>\
                                <strong>Campaign:</strong> <span style="color:#0073aa; font-weight:bold;"><?php echo esc_html($lead->utm_campaign ? $lead->utm_campaign : '-'); ?></span><br>\
                                <strong>Term:</strong> <?php echo esc_html($lead->utm_term ? $lead->utm_term : '-'); ?><br>\
                                <strong>GCLID:</strong> <small style="color:#777;"><?php echo esc_html($lead->gclid ? mb_strimwidth($lead->gclid, 0, 10, '...') : '-'); ?></small>\
                            </div>\
                        </td>\
                        <td>\
                            <div style="font-size:11px; line-height:1.5;">\
                                <strong>\uc0\u55357 \u56525  \u1601 \u1585 \u1608 \u1583 :</strong> <a href="<?php echo esc_url($lead->landing_page); ?>" target="_blank" style="font-family:monospace;"><?php echo esc_html(mb_strimwidth($landing_uri, 0, 20, '...')); ?></a><br>\
                                <strong>\uc0\u55356 \u57263  \u1705 \u1575 \u1606 \u1608 \u1585 \u1578 :</strong> <a href="<?php echo esc_url($lead->form_page); ?>" target="_blank" style="font-family:monospace;"><?php echo esc_html(mb_strimwidth($form_uri, 0, 20, '...')); ?></a>\
                            </div>\
                        </td>\
                        <td>\
                            <span style="font-family: Tahoma, Arial, sans-serif; font-size: 11px; color: #222; background: #e2f0fd; border: 1px solid #b4dbff; padding: 4px 8px; border-radius: 4px; display: inline-block; direction: rtl;">\
                                \uc0\u55357 \u56658  <?php echo esc_html(lts_get_jalali_date_v750($lead->created_at)); ?>\
                            </span>\
                        </td>\
                        <td class="status-col">\
                            <?php \
                            if($lead->status == 'sold') echo '<span style="color:green; font-weight:bold;">\uc0\u9989  \u1601 \u1585 \u1608 \u1588  \u1588 \u1583 </span>';\
                            elseif($lead->status == 'rejected') echo '<span style="color:#d63638; font-weight:bold;">\uc0\u10060  \u1585 \u1583  \u1588 \u1583 </span>';\
                            else echo '<span style="color:orange;">\uc0\u9203  \u1583 \u1585  \u1575 \u1606 \u1578 \u1592 \u1575 \u1585 </span>';\
                            ?>\
                        </td>\
                        <td>\
                            <button class="button lts-btn-action" data-id="<?php echo $lead->id; ?>" data-status="sold" style="background:#e5f5ea; color:green; border-color:#9ccc9c; margin-bottom:3px; display:block; width:100%; text-align:center; font-size:11px; padding:0; font-weight:bold;">\uc0\u1601 \u1585 \u1608 \u1588 </button>\
                            <button class="button lts-btn-action" data-id="<?php echo $lead->id; ?>" data-status="rejected" style="background:#fce8e6; color:#d63638; border-color:#f1b0b0; margin-bottom:3px; display:block; width:100%; text-align:center; font-size:11px; padding:0;">\uc0\u1585 \u1583  \u1604 \u1740 \u1583 </button>\
                        </td>\
                    </tr>\
                <?php \} \} ?>\
            </tbody>\
        </table>\
    </div>\
    <?php\
\}\
\
// \uc0\u1589 \u1601 \u1581 \u1607  \u1711 \u1586 \u1575 \u1585 \u1588  \u1606 \u1585 \u1582  \u1578 \u1576 \u1583 \u1740 \u1604  \u1705 \u1605 \u1662 \u1740 \u1606 \u8204 \u1607 \u1575  (\u1576 \u1583 \u1608 \u1606  \u1601 \u1740 \u1604 \u1583  \u1583 \u1585 \u1570 \u1605 \u1583 )\
function lts_render_reports_page_v750() \{\
    global $wpdb;\
    $table_name = $wpdb->prefix . 'lts_leads';\
    $reports = $wpdb->get_results("\
        SELECT utm_campaign, COUNT(id) as total_leads,\
        SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as total_sales,\
        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as total_rejected\
        FROM $table_name WHERE utm_campaign IS NOT NULL AND utm_campaign != '' GROUP BY utm_campaign\
    ");\
    ?>\
    <div class="wrap" style="direction: rtl;">\
        <h1>\uc0\u1711 \u1586 \u1575 \u1585 \u1588  \u1606 \u1585 \u1582  \u1578 \u1576 \u1583 \u1740 \u1604  \u1608 \u1575 \u1602 \u1593 \u1740  \u1705 \u1605 \u1662 \u1740 \u1606 \u8204 \u1607 \u1575 </h1>\
        <table class="wp-list-table widefat fixed striped" style="margin-top:20px;">\
            <thead>\
                <tr><th>\uc0\u1606 \u1575 \u1605  \u1705 \u1605 \u1662 \u1740 \u1606 </th><th>\u1578 \u1593 \u1583 \u1575 \u1583  \u1705 \u1604  \u1604 \u1740 \u1583 \u1607 \u1575 </th><th>\u1578 \u1593 \u1583 \u1575 \u1583  \u1601 \u1585 \u1608 \u1588  \u1605 \u1608 \u1601 \u1602 </th><th>\u1604 \u1740 \u1583  \u1576 \u1740 \u8204 \u1705 \u1740 \u1601 \u1740 \u1578  (\u1585 \u1583  \u1588 \u1583 \u1607 )</th><th>\u1606 \u1585 \u1582  \u1578 \u1576 \u1583 \u1740 \u1604  \u1604 \u1740 \u1583  \u1576 \u1607  \u1601 \u1585 \u1608 \u1588 </th></tr>\
            </thead>\
            <tbody>\
                <?php foreach ($reports as $row) \{ \
                    $cr = $row->total_leads > 0 ? round(($row->total_sales / $row->total_leads) * 100, 2) : 0;\
                    ?>\
                    <tr>\
                        <td><strong><?php echo esc_html($row->utm_campaign); ?></strong></td>\
                        <td><?php echo $row->total_leads; ?></td>\
                        <td><span style="color:green; font-weight:bold;"><?php echo $row->total_sales; ?></span></td>\
                        <td><span style="color:#d63638;"><?php echo $row->total_rejected; ?></span></td>\
                        <td><strong style="color: blue;"><?php echo $cr; ?>%</strong></td>\
                    </tr>\
                <?php \} ?>\
            </tbody>\
        </table>\
    </div>\
    <?php\
\}\
\
// \uc0\u1781 . \u1607 \u1606 \u1583 \u1604 \u1585  \u1662 \u1585 \u1583 \u1575 \u1586 \u1588 \u1711 \u1585  \u1575 \u1740 \u1580 \u1705 \u1587  \u1575 \u1583 \u1605 \u1740 \u1606  (\u1608 \u1575 \u1606 -\u1705 \u1604 \u1740 \u1705  \u1576 \u1583 \u1608 \u1606  \u1583 \u1585 \u1740 \u1575 \u1601 \u1578  \u1602 \u1740 \u1605 \u1578 )\
add_action('wp_ajax_lts_update_status', 'lts_enterprise_ajax_update_status_v750');\
function lts_enterprise_ajax_update_status_v750() \{\
    check_ajax_referer('lts_admin_nonce', 'nonce');\
    global $wpdb;\
    $id = intval($_POST['id']);\
    $status = sanitize_text_field($_POST['status']);\
\
    $wpdb->update($wpdb->prefix . 'lts_leads', array('status' => $status), array('id' => $id));\
    wp_send_json_success();\
\}\
\
add_action('admin_footer', 'lts_enterprise_admin_script_v750');\
function lts_enterprise_admin_script_v750() \{\
    ?>\
    <script type="text/javascript">\
    jQuery(document).ready(function($) \{\
        $('.lts-btn-action').on('click', function(e) \{\
            e.preventDefault();\
            var button = $(this);\
            var leadId = button.data('id');\
            var status = button.data('status');\
\
            var confirmMsg = (status === 'sold') ? "\uc0\u1570 \u1740 \u1575  \u1575 \u1740 \u1606  \u1604 \u1740 \u1583  \u1576 \u1607  \u1593 \u1606 \u1608 \u1575 \u1606  \'ab\u1601 \u1585 \u1608 \u1588  \u1605 \u1608 \u1601 \u1602 \'bb \u1579 \u1576 \u1578  \u1588 \u1608 \u1583 \u1567 " : "\u1570 \u1740 \u1575  \u1575 \u1740 \u1606  \u1604 \u1740 \u1583  \u1576 \u1607  \u1593 \u1606 \u1608 \u1575 \u1606  \'ab\u1576 \u1740 \u8204 \u1705 \u1740 \u1601 \u1740 \u1578  / \u1585 \u1583  \u1588 \u1583 \u1607 \'bb \u1579 \u1576 \u1578  \u1588 \u1608 \u1583 \u1567 ";\
            if (!confirm(confirmMsg)) return;\
\
            $.ajax(\{\
                url: '<?php echo admin_url('admin-ajax.php'); ?>',\
                type: 'POST',\
                data: \{\
                    action: 'lts_update_status',\
                    id: leadId,\
                    status: status,\
                    nonce: '<?php echo wp_create_nonce('lts_admin_nonce'); ?>'\
                \},\
                success: function(response) \{\
                    if (response.success) \{\
                        var row = $('#lead-row-' + leadId);\
                        if (status === 'sold') \{\
                            row.find('.status-col').html('<span style="color:green; font-weight:bold;">\uc0\u9989  \u1601 \u1585 \u1608 \u1588  \u1588 \u1583 </span>');\
                        \} else \{\
                            row.find('.status-col').html('<span style="color:#d63638; font-weight:bold;">\uc0\u10060  \u1585 \u1583  \u1588 \u1583 </span>');\
                        \}\
                    \}\
                \}\
            \});\
        \});\
    \});\
    </script>\
    <?php\
\}\
\
// \uc0\u1782 . \u1582 \u1585 \u1608 \u1580 \u1740  \u1578 \u1601 \u1705 \u1740 \u1705 \u8204 \u1588 \u1583 \u1607  \u1575 \u1705 \u1587 \u1604  \u1576 \u1575  \u1575 \u1593 \u1605 \u1575 \u1604  \u1607 \u1608 \u1588 \u1605 \u1606 \u1583  \u1601 \u1740 \u1604 \u1578 \u1585 \u1607 \u1575  (\u1576 \u1583 \u1608 \u1606  \u1587 \u1578 \u1608 \u1606  \u1602 \u1740 \u1605 \u1578 )\
add_action('admin_init', 'lts_enterprise_handle_csv_export_v750');\
function lts_enterprise_handle_csv_export_v750() \{\
    if (!isset($_GET['action']) || $_GET['action'] !== 'lts_export_csv_v750') return;\
\
    global $wpdb;\
    $table_name = $wpdb->prefix . 'lts_leads';\
    \
    $campaign_filter = isset($_GET['campaign_filter']) ? sanitize_text_field($_GET['campaign_filter']) : '';\
    $status_filter = isset($_GET['status_filter']) ? sanitize_text_field($_GET['status_filter']) : '';\
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';\
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';\
\
    $where = " WHERE 1=1";\
    if (!empty($campaign_filter)) $where .= $wpdb->prepare(" AND utm_campaign = %s", $campaign_filter);\
    if (!empty($status_filter)) $where .= $wpdb->prepare(" AND status = %s", $status_filter);\
    if (!empty($start_date)) $where .= $wpdb->prepare(" AND created_at >= %s", $start_date . ' 00:00:00');\
    if (!empty($end_date)) $where .= $wpdb->prepare(" AND created_at <= %s", $end_date . ' 23:59:59');\
\
    $leads = $wpdb->get_results("SELECT * FROM $table_name $where ORDER BY id DESC", ARRAY_A);\
    $discovered_fields = get_option('lts_discovered_fields', array());\
\
    header('Content-Type: text/csv; charset=utf-8');\
    header('Content-Disposition: attachment; filename=leads-filtered-report-'.date('Y-m-d').'.csv');\
    \
    $output = fopen('php://output', 'w');\
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); \
    \
    $csv_headers = array('\uc0\u1588 \u1606 \u1575 \u1587 \u1607 ');\
    foreach ($discovered_fields as $field) \{\
        $csv_headers[] = '\uc0\u1601 \u1740 \u1604 \u1583  (' . $field . ')';\
    \}\
    $csv_headers = array_merge($csv_headers, array('\uc0\u1605 \u1606 \u1576 \u1593  (Source)', '\u1585 \u1587 \u1575 \u1606 \u1607  (Medium)', '\u1705 \u1605 \u1662 \u1740 \u1606  (Campaign)', '\u1705 \u1604 \u1605 \u1607  \u1705 \u1604 \u1740 \u1583 \u1740  (Term)', '\u1588 \u1606 \u1575 \u1587 \u1607  \u1711 \u1608 \u1711 \u1604  (GCLID)', '\u1589 \u1601 \u1581 \u1607  \u1604 \u1606 \u1583 \u1740 \u1606 \u1711 ', '\u1589 \u1601 \u1581 \u1607  \u1579 \u1576 \u1578  \u1601 \u1585 \u1605 ', '\u1578 \u1575 \u1585 \u1740 \u1582  \u1579 \u1576 \u1578  (\u1578 \u1607 \u1585 \u1575 \u1606 )', '\u1608 \u1590 \u1593 \u1740 \u1578  \u1605 \u1575 \u1604 \u1740 '));\
    \
    fputcsv($output, $csv_headers);\
    \
    foreach ($leads as $lead) \{\
        $data_array = json_decode($lead['form_data'], true);\
        if (!is_array($data_array)) \{ $data_array = array(); \}\
\
        $row_data = array($lead['id']);\
        foreach ($discovered_fields as $field) \{\
            $row_data[] = isset($data_array[$field]) ? $data_array[$field] : '';\
        \}\
\
        $row_data = array_merge($row_data, array(\
            $lead['utm_source'], $lead['utm_medium'], $lead['utm_campaign'], $lead['utm_term'], $lead['gclid'],\
            $lead['landing_page'], $lead['form_page'], lts_get_jalali_date_v750($lead['created_at']), $lead['status']\
        ));\
\
        fputcsv($output, $row_data);\
    \}\
    fclose($output);\
    exit;\
\}}