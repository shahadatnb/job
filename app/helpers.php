<?php
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Carbon\Carbon;
//use Illuminate\Support\Str;

function settingAll(){
    if(class_exists('DB')){
      if(DB::connection()->getPdo()){
        return Setting::where('category','basic')->pluck('value','name')->toArray();
      }
    }
}

function settingValue($col){
        return Setting::where('name',$col)->pluck('value')->first();
    }

function sendSms($contact,$msg,$smsType = 'text'){
    $connected = @fsockopen("sms.rampsbd.com", 80);  //website, port  (try 80 or 443)
    if ($connected){
        $msg = urlencode($msg);
        file_get_contents("http://sms.rampsbd.com/smsapi?api_key=".config('settings.sms_api_key',null)."&type=".$smsType."&contacts=".$contact."&senderid=".config('settings.sms_senderid',null)."&msg=".$msg);
    }

    //$status=file_get_contents("http://sms.rampsbd.com/miscapi/C20015595aeaf3b16ee668.16154193/getDLR/getAll");

//$balance=file_get_contents("http://sms.rampsbd.com/miscapi/C20015595aeaf3b16ee668.16154193/getBalance");
}

function smsBalance(){
    $connected = @fsockopen("sms.rampsbd.com", 80);  //website, port  (try 80 or 443)
    if ($connected){
        return file_get_contents("http://sms.rampsbd.com/miscapi/".config('settings.sms_api_key', 'Laravel')."/getBalance");
        fclose($connected);
    }else{
        return '0:0';
    }
}
/*
if(Auth::user()->photo):
    $profilePhoto=Auth::user()->photo;
else:
    $profilePhoto='assets/admin/img/avatar.png';
endif; */
function NaveMenuUrl($item, $linkClass){
    if($item->menuType == 'extrenal'):
        $url = $item->menu_url;
    /* elseif($item->menuType == 'page'):
        $url = url('/page').'/'.$item->menu_url; */
    elseif($item->menuType == 'home'):
        $url = url('/');
    else://($item->menuType == 'others'):
        $url = url('/').'/'.$item->menu_url;
    endif;

    return "<a class=\"{$linkClass}\" href=\"{$url}\">{$item->lebel}</a>";
}

function NaveMenu($menu_id, $menuClass='menu', $listClass='', $listParentClass='', $subMenuClass='', $linkClass='nav-link'){
    $menu = Menu::where('menu_id',$menu_id)->first();
    if($menu->menuItem->count()>0):
        $nav = "<ul class=\"{$menuClass}\">";
        foreach($menu->menuItem as $item){
                if($item->subMenu->count()>0):
                    $nav .= '<li class='.$listParentClass.'>'.NaveMenuUrl($item, $linkClass);
                        $nav .= "<ul class=\"{$subMenuClass}\">";
                            foreach ($item->subMenu as $subItem):
                                $nav .= '<li class='.$listClass.'>'.NaveMenuUrl($subItem, $linkClass).'</li>';
                            endforeach;
                        $nav .= '</ul>';
                    $nav .= '</li>';
                else:
                    $nav .= '<li class='.$listClass.'>'.NaveMenuUrl($item, $linkClass).'</li>';
                endif;
            }
        $nav .= '</ul>';
        return $nav;
    else:
        return '';
    endif;
}


function nextDate($date){
    $date1 = Carbon::parse($date)->addDays(1);
    return $date1->toDateString();
}

function preDate($date){
    $date1 = Carbon::parse($date)->addDays(-1);
    return $date1->toDateString();
}


/**
 * @param null $title
 * @param null $message
 * @return \Illuminate\Foundation\Application|mixed
 * For the flash messages.
 */
function flash($title = null, $message = null) {
    // Set variable $flash to fetch the Flash Class
    // in Flash.php
    $flash = app('App\Http\Flash');

    // If 0 parameters are passed in ($title, $message)
    // then just return the flash instance.
    if (func_num_args() == 0) {
        return $flash;
    }

    // Just return a regular flash->info message
    return $flash->info($title, $message);
}

/**
 * @param $date
 * @return bool|string
 * Format the time to this
 composer dump-autoload
 */
function shortDate($date) {
    return date("d-m-y", strtotime($date));
}

function prettyDate($date) {
    return date("d-m-Y", strtotime($date));
}

function prettyDateTime($date) {
    return date("d-m-Y h:i A", strtotime($date));
}

function prettyDateS($date) {
    return date("d/m", strtotime($date));
}

function numberTowords($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    $final = implode(' ', $words);
    return ucwords($final.' taka only.');
}

function fileIcom($file){
    $info = pathinfo(url('/public').'/upload/files/'.$file);
    $ext = $info['extension'];

    switch ($ext) {
    case 'pdf':
        return 'file-pdf-o';
        break;
    case 'doc':
        return 'file-word-o';
        break;
    case 'docx':
        return 'file-word-o';
        break;
    case 'xls':
        return 'file-excel-o';
        break;
    case 'xlsx':
        return 'file-excel-o';
        break;
    case 'ppt':
        return 'file-powerpoint-o';
        break;
    case 'pptx':
        return 'file-powerpoint-o';
        break;
    case 'zip':
        return 'file-zip-o';
        break;
    default:
        return 'file';
    }

}

if (!function_exists('getShorterString')) {
    function getShorterString($text, $length=null)
    {
        $formatedString = ucwords($text);

        if ($length != null) {
            if (strlen($formatedString) <= $length) {
                return $formatedString;
            } else {
                $y=substr($formatedString, 0, $length) . '...';
                return $y;
            }
        } else {
            return $formatedString;
        }
    }
}
