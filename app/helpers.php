<?php


function qs_url($path = null, $qs = [], $secure = null)
{
    $url = app('url')->to($path, $secure);

    if (count($qs)) {
        foreach ($qs as $key => $value) {
            $qs[$key] = sprintf('%s=%s', $key, urlencode($value));
        }

        $url = sprintf('%s?%s', $url, implode('&', $qs));
    }

    return $url;
}

function url_fix($path = null, $parameters = [], $secure = null)
{
    $url = url($path, $parameters ? "?{$parameters}" : $parameters, $secure);
    $url = urldecode($url);
    $url = str_replace('?&', '?', $url);
    $url = str_replace('/?', '?', $url);

    return $url;
}



function preUrlFilter(&$url, $list, $custom = [])
{
    foreach ($list as $key) {
        if (request()->query->has($key)) {
            if (isset($custom[$key])) {
                $url[$key] = $custom[$key];
            } else {
                $url[$key] = request()->query($key);
            }
        }
    }

    return $url;
}

function preFormPost(&$data, $list, $post, $info = [])
{
    foreach ($list as $key => $default) {
        if (isset($post[$key])) {
            $data[$key] = $post[$key];
        } elseif (!empty($info) && isset($info->{$key})) {
            $data[$key] = $info->{$key};
        } else {
            $data[$key] = $default;
        }
    }
}

function preFormError(&$data, $list, $error)
{
    foreach ($list as $key => $default) {
        if (isset($error[$key])) {
            $data['error_' . $key] = $error[$key];
        } else {
            $data['error_' . $key] = $default;
        }
    }
}

function time_ago($start, $end)
{
    $diff = strtotime($end) - strtotime($start);

    // Time difference in seconds
    $sec = $diff;

    // Convert time difference in minutes
    $min = round($diff / 60, 2);

    // Convert time difference in hours
    $hrs = round($diff / 3600, 2);

    // Convert time difference in days
    $days = round($diff / 86400, 2);

    // Convert time difference in weeks
    $weeks = round($diff / 604800, 2);

    // Convert time difference in months
    $mnths = round($diff / 2600640, 2);

    // Convert time difference in years
    $yrs = round($diff / 31207680, 2);

    // Check for seconds
    if ($sec <= 60) {
        return "$sec seconds";
    } else if ($min <= 60) {
        if ($min == 1) {
            return "1 minute";
        } else {
            return "$min minutes";
        }
    } else if ($hrs <= 24) {
        if ($hrs == 1) {
            return "1 hour";
        } else {
            return "$hrs hours";
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return "Yesterday";
        } else {
            return "$days days";
        }
    } else if ($weeks <= 4.3) {
        if ($weeks == 1) {
            return "1 week";
        } else {
            return "$weeks weeks";
        }
    } else if ($mnths <= 12) {
        if ($mnths == 1) {
            return "1 month";
        } else {
            return "$mnths months";
        }
    } else {
        if ($yrs == 1) {
            return "1 year";
        } else {
            return "$yrs years";
        }
    }
}

function highlight_search($input, $searchString, $css = 'is-match')
{
    return str_replace($searchString, "<span class=\"$css\">$searchString</span>", $input);
}


function hed($string, $quote_style = ENT_QUOTES, $charset = 'utf-8')
{
    return html_entity_decode($string, $quote_style, $charset);
}

function vn_filter_mark($str, $charSpace = '-')
{
    $str = utf8_strtolower($str);

    $str = str_replace(['à', 'À', 'á', 'Á', 'ạ', 'Ạ', 'ả', 'Ả', 'ã', 'Ã', 'â', 'Â', 'ầ', 'ấ', 'Ấ', 'ậ', 'Ậ', 'ẩ', 'Ẩ', 'ẫ', 'Ẫ', 'ă', 'Ă', 'ằ', 'Ằ', 'ắ', 'Ắ', 'ặ', 'Ặ', 'ẳ', 'Ẳ', 'ẵ', 'Ẵ'], "a", $str);
    $str = str_replace(['è', 'È', 'é', 'É', 'ẹ', 'Ẹ', 'ẻ', 'Ẻ', 'ẽ', 'Ẽ', 'ê', 'Ê', 'ề', 'Ề', 'ế', 'Ế', 'ệ', 'Ệ', 'ể', 'Ể', 'ễ', 'Ễ'], "e", $str);
    $str = str_replace(['ì', 'Ì', 'í', 'Í', 'ị', 'Ị', 'ỉ', 'Ỉ', 'ĩ', 'Ĩ'], "i", $str);
    $str = str_replace(['ò', 'Ò', 'ó', 'Ó', 'ọ', 'Ọ', 'ỏ', 'Ỏ', 'õ', 'Õ', 'ô', 'Ô', 'ồ', 'Ồ', 'ố', 'Ố', 'ộ', 'Ộ', 'ổ', 'Ổ', 'ỗ', 'Ỗ', 'ơ', 'Ơ', 'ờ', 'Ờ', 'ớ', 'Ớ', 'ợ', 'Ợ', 'ở', 'Ở', 'ỡ', 'Ỡ'], "o", $str);
    $str = str_replace(['ù', 'Ù', 'ú', 'Ú', 'ụ', 'Ụ', 'ủ', 'Ủ', 'ũ', 'Ũ', 'ư', 'Ư', 'ừ', 'Ừ', 'ứ', 'Ứ', 'ự', 'Ự', 'ử', 'Ử', 'ữ', 'Ữ'], "u", $str);
    $str = str_replace(['ỳ', 'Ỳ', 'ý', 'Ý', 'ỵ', 'Ỵ', 'ỷ', 'Ỷ', 'ỹ', 'Ỹ'], "y", $str);
    $str = str_replace(['đ', 'Đ'], "d", $str);
    $str = str_replace(['!', '@', '%', '\^', '*', '\(', '\)', '\+', '\=', '<', '>', '?', '/', '\\', ',', '\.', ':', '\;', '\'', ' ', '"', '\&', '\#', '\[', '\]', '~', '$', '&', ';', '_', '|'], $charSpace, $str);
    $str = str_replace(['-+-'], $charSpace, $str);
    $str = str_replace(['^\-+', '\-+$'], "", $str);

    return $str;
}


function unmark($str)
{
    $charSpace = ' ';

    $str = utf8_strtolower($str);

    $str = str_replace(['à', 'À', 'á', 'Á', 'ạ', 'Ạ', 'ả', 'Ả', 'ã', 'Ã', 'â', 'Â', 'ầ', 'ấ', 'Ấ', 'ậ', 'Ậ', 'ẩ', 'Ẩ', 'ẫ', 'Ẫ', 'ă', 'Ă', 'ằ', 'Ằ', 'ắ', 'Ắ', 'ặ', 'Ặ', 'ẳ', 'Ẳ', 'ẵ', 'Ẵ'], "a", $str);
    $str = str_replace(['è', 'È', 'é', 'É', 'ẹ', 'Ẹ', 'ẻ', 'Ẻ', 'ẽ', 'Ẽ', 'ê', 'Ê', 'ề', 'Ề', 'ế', 'Ế', 'ệ', 'Ệ', 'ể', 'Ể', 'ễ', 'Ễ'], "e", $str);
    $str = str_replace(['ì', 'Ì', 'í', 'Í', 'ị', 'Ị', 'ỉ', 'Ỉ', 'ĩ', 'Ĩ'], "i", $str);
    $str = str_replace(['ò', 'Ò', 'ó', 'Ó', 'ọ', 'Ọ', 'ỏ', 'Ỏ', 'õ', 'Õ', 'ô', 'Ô', 'ồ', 'Ồ', 'ố', 'Ố', 'ộ', 'Ộ', 'ổ', 'Ổ', 'ỗ', 'Ỗ', 'ơ', 'Ơ', 'ờ', 'Ờ', 'ớ', 'Ớ', 'ợ', 'Ợ', 'ở', 'Ở', 'ỡ', 'Ỡ'], "o", $str);
    $str = str_replace(['ù', 'Ù', 'ú', 'Ú', 'ụ', 'Ụ', 'ủ', 'Ủ', 'ũ', 'Ũ', 'ư', 'Ư', 'ừ', 'Ừ', 'ứ', 'Ứ', 'ự', 'Ự', 'ử', 'Ử', 'ữ', 'Ữ'], "u", $str);
    $str = str_replace(['ỳ', 'Ỳ', 'ý', 'Ý', 'ỵ', 'Ỵ', 'ỷ', 'Ỷ', 'ỹ', 'Ỹ'], "y", $str);
    $str = str_replace(['đ', 'Đ'], "d", $str);
    $str = str_replace(['!', '@', '%', '\^', '*', '(', ')', '\(', '\)', '\+', '\=', '<', '>', '?', '/', '\\', ',', '\.', ':', '\;', '\'', ' ', '"', '\&', '\#', '\[', '\]', '~', '$', '&', ';', '_', '|'], $charSpace, $str);
    $str = str_replace(['-+-'], $charSpace, $str);
    $str = str_replace(['^\-+', '\-+$'], "", $str);
    $str = preg_replace('/\s+/', ' ', $str);

    return $str;
}

