<?php

function lightLoop($light_data) {
        $output = "";
        $output .= "\t<div class=\"col-xs-12 col-sm-4 col-md-3 col-lg-2\">\n";
                $output .= "\t\t<div class=\"panel panel-default clearfix\">\n";
                    $output .= "\t\t\t<div class=\"panel-heading clearfix\">\n";
                        $output .= "\t\t\t\t<div class=\"col-md-12 col-lg-12 pull-left\">\n";
                                //$output .= "\t\t\t\t\t<div>" . $light_data[$x]["name"] . "&nbsp;" . $light_data[$x]["dState"]) . "</div>\n";
                        $output .= "\t\t\t\t</div>\n";
                    $output .= "\t\t\t</div>\n";
                $output .= "\t\t</div>\n";
        $output .= "\t</div>\n";
        $f = fopen("/sys/class/thermal/thermal_zone0/temp","r");
        $temp = fgets($f);
        fclose($f);
        $output .= "\t<div class=\"col-xs-12 col-sm-4 col-md-3 col-lg-2\">\n";
                $output .= "\t\t<div class=\"panel panel-default clearfix\">\n";
                    $output .= "\t\t\t<div class=\"panel-heading clearfix\">\n";
                        $output .= "\t\t\t\t<div class=\"col-md-12 col-lg-12 pull-left\">\n";
                                $output .= "\t\t\t\t\t<div>RPi:&nbsp;" . (((round($temp/1000) * 9) / 5) + 32) . "&deg;</div>\n";
                        $output .= "\t\t\t\t</div>\n";
                    $output .= "\t\t\t</div>\n";
                $output .= "\t\t</div>\n";
        $output .= "\t</div>\n";
        return $output
}

function tempLoop($temp_data) {
        $output = "";
        for($x = 0; $x <= count($temp_data) - 1; $x++) {
        $output .= "\t<div class=\"col-xs-12 col-sm-4 col-md-3 col-lg-2\">\n";
                $output .= "\t\t<div class=\"panel panel-default clearfix\">\n";
                    $output .= "\t\t\t<div class=\"panel-heading clearfix\">\n";
                        $output .= "\t\t\t\t<div class=\"col-md-12 col-lg-12 pull-left\">\n";
                                $output .= "\t\t\t\t\t<div>" . str_replace("28-041636e1c5ff", "Hot Tub" , str_replace("28-041636e1d6ff", "Pool", $temp_data[$x]["id"])) . ":&nbsp;" . round($temp_data[$x]["temp"]) . "&deg;</div>\n";
                        $output .= "\t\t\t\t</div>\n";
                    $output .= "\t\t\t</div>\n";
                $output .= "\t\t</div>\n";
        $output .= "\t</div>\n";
        }
        return $output;
}
function deviceLoop($ha_devices) {
        for($x = 0; $x <= count($ha_devices) - 1; $x++) {
        if($ha_devices[$x]["inactive"] == false){
        $dev_level = (is_numeric($ha_devices[$x]["deviceState"]["bri"])) ? round(($ha_devices[$x]["deviceState"]["bri"] / 255)*100) : 0;
        $bar_level = ($ha_devices[$x]["deviceState"]["on"] == 1) ? round(($ha_devices[$x]["deviceState"]["bri"] / 255)*100) : 0 ;
        $output .= "\t<div class=\"col-xs-12 col-sm-4 col-md-3 col-lg-2\">\n";
            $output .= "\t\t<form class=\"form-inline\" id=\"" . $ha_devices[$x]["id"] . "\">\n";
                $output .= "\t\t\t<div class=\"panel panel-default clearfix\">\n";
                    $output .= "\t\t\t\t<div class=\"panel-heading clearfix\">\n";
                        $output .= "\t\t\t\t\t<div class=\"col-md-12 col-lg-12\">\n";
                                $output .= "\t\t\t\t\t\t<div class=\"pull-left hideOverflow\">\n";
                                $output .= "\t\t\t\t\t\t\t<label for=\"bu" . $ha_devices[$x]["id"] . "\" class=\"checkbox-inline\">\n";
                                $output .= "\t\t\t\t\t\t\t\t<input type=\"checkbox\" data-toggle=\"toggle\" data-size=\"mini\" name=\"action\" value=\"";
                                $output .= ($ha_devices[$x]["deviceState"]["on"] == 1) ? "off" : "on";
                                $output .= "\" data-onstyle=\"success\" id=\"bu" . $ha_devices[$x]["id"] . "\" class=\"toggle-group\"";
                                $output .= ($ha_devices[$x]["deviceState"]["on"] == 1) ? " checked" : "";
                                $output .= ">" . str_replace(". ", ".", ucwords(str_replace(".", ". ", $ha_devices[$x]["name"]))) . "&nbsp;<span id=\"prog" . $ha_devices[$x]["id"] . "\">" . $bar_level . "</span>%\n";
                                $output .= "\t\t\t\t\t\t\t</label>\n";
                                $output .= "\t\t\t\t\t\t</div>\n";
                                $output .= "\t\t\t\t\t\t<div class=\"pull-right Xtoggle\">\n";
                                $output .= ((strpos($ha_devices[$ha_val]["onUrl"],"percent") > 0)||(($ha_devices[$x]["dimUrl"])&&($ha_devices[$x]["dimUrl"] != "[]"))) ? "\t\t\t\t\t\t\t<span class=\"glyphicon glyphicon-chevron-down expand\"></span><span class=\"glyphicon glyphicon-chevron-up l expand\"></span>" : "" ;
                                $output .= "\n\t\t\t\t\t\t</div>\n";
                        $output .= "\t\t\t\t\t</div>\n";
                    $output .= "\t\t\t\t</div>\n";
                    $output .= "\t\t\t\t<div class=\"panel-body row-fluid\">\n";
                        $output .= "\t\t\t\t\t<div class=\"col-sm-12 col-md-12 col-lg-12\">\n";
                                $output .= "\t\t\t\t\t\t<div class=\"min-height\">\n";
                                        $output .= "\t\t\t\t\t\t\t<input class=\"";
                                        $output .= ((strpos($ha_devices[$ha_val]["onUrl"],"percent") > 0)||(($ha_devices[$x]["dimUrl"])&&($ha_devices[$x]["dimUrl"] != "[]"))) ? "sl" : "slhidden";
                                        $output .= "\" id=\"sl" . $ha_devices[$x]["id"] . "\" type=\"";
                                        $output .= ((strpos($ha_devices[$ha_val]["onUrl"],"percent") > 0)||(($ha_devices[$x]["dimUrl"])&&($ha_devices[$x]["dimUrl"] != "[]"))) ? "hidden" : "hidden";
                                        $output .= "\" min=\"1\" max=\"100\" step=\"1\" data-slider-min=\"1\" data-slider-max=\"100\" data-slider-step=\"1\" data-slider-value=\"";
                                        $output .= (($dev_level < 100) && ($dev_level != 0)) ? $dev_level : "100";
                                        $output .= "\" />\n";
                                $output .= "\t\t\t\t\t\t</div>\n";
                        $output .= "\t\t\t\t\t</div>\n";
                    $output .= "\t\t\t\t</div>\n";
                $output .= "\t\t\t</div>\n";
        $output .= "\t\t<input type=\"hidden\" id=\"ps" . $ha_devices[$x]["id"] . "\" value=\"";
        $output .= (($dev_level < 100) && ($dev_level != 0)) ? $dev_level : "100";
        $output .= "\" />\n";
        $output .= "\t\t</form>\n";
        $output .= "\t</div>\n";
        }
        }
        return $output;
}
function controls($SN, $fields, $field, $sorts, $sort) {
        $output = "";
        $output .= "\t<form class=\"form form-inline\">\n";
            $output .= "\t\t<nav class=\"navbar fixed-top navbar-inverse bg-inverse\">\n";
                $output .= "\t\t\t<div class=\"col\">\n";
                    $output .= "\t\t\t\t<div class=\"col-xs-9 col-sm-4 col-md-4\">\n";
                        $output .= "\t\t\t\t\t<a class=\"navbar-brand\" title=\"Go to HA Bridge\" href=\"http://" . $SN . "\">Monkey&nbsp;Control</a>\n";
                    $output .= "\t\t\t\t</div>\n";
                    $output .= "\t\t\t\t<div class=\"col-xs-3 col-sm-2 col-md-2 pull-right\">\n";
                        $output .= "\t\t\t\t\t<ul class=\"nav navbar-nav navbar-right\">\n\t\t\t\t\t\t<li class=\"text-right\"><a href=\"?logout=true\" title=\"Logout of Monkey Control\"><span class=\"hidden-xs\">&nbsp;Logout&nbsp;</span><span class=\"glyphicon glyphicon-log-out\"></span></a></li>\n\t\t\t\t\t</ul>\n";
                    $output .= "\t\t\t\t</div>\n";
                    $output .= "\t\t\t\t<div class=\"clearfix visible-xs\"></div>\n";
                    $output .= "\t\t\t\t<div class=\"col-xs-12 col-sm-6 col-md-6\">\n";
                        $output .= "\t\t\t\t\t<select class=\"selectpicker form-control\" id=\"field\" name=\"field\">\n";
                        foreach($fields as $value) {
                                $output .= "\t\t\t\t\t\t\t\t\t<option";
                                $output .= ($field == $value) ? " selected" : "" ;
                                $output .= ">" . $value . "</option>\n";
                        }
                        $output .= "\t\t\t\t\t</select>\n";
                        $output .= "\t\t\t\t\t<select class=\"selectpicker form-control\" id=\"sort\" name=\"sort\">\n";
                        foreach($sorts as $value) {
                                $output .= "\t\t\t\t\t\t\t\t\t<option";
                                $output .= (str_replace("SORT_", "", $sort) == $value) ? " selected" : "" ;
                                $output .= ">" . $value . "</option>\n";
                        }
                        $output .= "\t\t\t\t\t</select>\n";
                        $output .= "\t\t\t\t\t<button type=\"submit\" class=\"btn btn-default navbar-btn\">Go</button>\n";
                    $output .= "\t\t\t\t</div>\n";
                $output .= "\t\t\t</div>\n";
            $output .= "\t\t</nav>\n";
        $output .= "\t</form>\n";
        return $output;
}
?>
