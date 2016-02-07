<?php
extract($_POST);
$heyuvar = "heyu -c /home/pi/.heyu/x10config ";
$heyuend = " > /dev/null 2>/dev/null &";
if((isset($hu)) && (isset($action))) {
        if (is_numeric($action)) {
                $level = (22 - round($action * (22 / 100)) == 0) ? 1 : 22 - round($action * (22 / 100));
                $heyuvar .= 'obdim ' . $hu . ' ' . $level . $heyuend;
        }else{
                $heyuvar .= $action . ' ' . $hu . $heyuend;
        }
        exec($heyuvar);
        header("Location: /hub.php");
        exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link href="startup.png" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link rel="apple-touch-icon" href="x10switch_icon.png"/>
<title>Lighting</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-responsive.css">
<link rel="stylesheet" href="bootstrap-theme.min.css">
<style>
body,.panel-body,.panel{background-color:#000;border:0}
</style>
</head>
<body>
<div class="container container-fluid" role="main">
        <div class="row">
                <div class="col-sm-3">
                        <div class="panel panel-default">
                                <div class="panel-body">
<?php
$get_alias = $heyuvar . 'show alias';
$devices = explode(":", preg_replace('/( )+/', ' ', str_replace("alias", ":", str_replace("[Aliases]", "", shell_exec($get_alias)))) . ":");
if (!empty($devices)) {
        $count = 0;
        foreach ($devices as &$device) {
                list($dev_name, $dev_address, $dev_type) = explode(":", str_replace(" ", ":", trim($device)));
                $get_level = $heyuvar . 'dimlevel ' . $dev_address;
                if ($dev_address) {
                        $dev_level = trim(exec($get_level));
                        if (($dev_type != "StdLM") && ($dev_level > 0)) $dev_level = 100;
?>
                                        <h4><span class="label label-primary"><?php echo ucwords(str_replace("_", " ", $dev_name)); ?>&nbsp;<span class="badge"><?php echo $dev_level . "%"; ?></span></span></h4>
                                        <div style="margin:0 0 4px 0">
                                        <form class="form-inline" method="post" action="/hub.php">
                                                <input type="hidden" name="hu" value="<?php echo $dev_address; ?>" />
                                                <button type="submit" class="btn btn-lg btn-success" name="action" value="on">on</button>
                                                <button type="submit" class="btn btn-lg btn-danger" name="action" value="off">off</button>
                                        </form>
                                        </div>
<?php
                }
                if(($count % 4 === 0)&&($count > 0)&&($count < (count($devices)-1))) {
?>
                                </div>
                        </div>
                </div>
                <div class="col-sm-3">
                        <div class="panel panel-default">
                                <div class="panel-body">
<?php
                }
                $count++;
                $totolcount++;
        }
}
?>
                                </div>
                        </div>
                </div>
        </div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js?ver=CDN"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>