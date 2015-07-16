<?php namespace Controllers;

use Core\View,
    Helpers\Url,
    Core\Controller;
use Helpers\SimpleCurl as Curl;
class Rests extends Controller {
  private $_model;
  private $_rests_file = 'rests.json';

  public function __construct(){
    parent::__construct();
    $this->_model = new \Models\Rests();
  }

  public function fetch_restaurant_info($force = false) {

    //Make sure file exists
    if (is_file($this->_rests_file) === false) {
        file_put_contents($this->_rests_file, '');
    }

    //Parse info from existing file and get last update info
    $content = json_decode(file_get_contents($this->_rests_file));
    $last_update = (time() - $content->timestamp) / 60;
    unset($content->timestamp);

    if (!$content || !$last_update || $last_update > 10 * 60 || $force) {
      $f = fopen($this->_rests_file, "r+");
      if ($f !== false) {
        ftruncate($f, 0);
        fclose($f);
      }

      //Get and parse data
      $url = 'http://www.10bis.co.il/Restaurants/SearchRestaurants?deliveryMethod=Delivery&ShowOnlyOpenForDelivery=False&id=942159&pageNum=0&pageSize=1000&ShowOnlyOpenForDelivery=false&OrderBy=delivery_sum&cuisineType=&StreetId=0&FilterByKosher=false&FilterByBookmark=false&FilterByCoupon=false&searchPhrase=&Latitude=32.075523&Longitude=34.795268&timestamp=1387750840791';
      $content = json_decode(Curl::get($url));
      $content['timestamp'] = time();
      file_put_contents($this->_rests_file, json_encode($content));

      //TODO: Parse data and update db if needed
    } else {
      $content = json_decode(file_get_contents($this->_rests_file));
    }

    return $content;
  }

  public function index()
  {
      $data['title'] = 'מסעדות';
      $data['rests'] = $this->_model->get_restaurants();
    if (empty($data['rests'])) {
      $data['restaurants'] = $this->fetch_restaurant_info();

      //parse data
      foreach ($data['restaurants'] as $rest) {
        $rest_id = $rest->RestaurantId;
        $rest_name = $rest->RestaurantName;
        $rest_address = $rest->RestaurantAddress;
        $rest_logo = $rest->RestaurantLogoUrl;

        $rest_data = array(
          'rest_id' => $rest_id,
          'rest_name' => $rest_name,
          'rest_address' => $rest_address,
          'rest_logo' => $rest_logo
        );

        print_r($this->_model->add_restaurant($rest_data));
        echo "<div><h2>$rest_name</h2><img src='$rest_logo' /></div>";
      }
    }

// foreach($data['rests'] as $row){
//   //$this->_model->get_dishes();
//   //echo "Working on $row->rest_name<br/>";

//   $url = DIR . "rests/$row->rest_id";
//   echo "<script>";
//   echo "ajax.get('$url', {}, function() {});";
//   echo "</script>";
// }

      View::renderTemplate('header', $data);
      View::render('rests', $data);
      View::renderTemplate('footer', $data);
  }

  public function rest($rest_id)
  {
      $data['rest'] = $this->_model->get_restaurant($rest_id);
      $data['title'] = $data['rest'][0]->rest_name;
      $data['dishes'] = $this->_model->get_dishes($rest_id);

      if (empty($data['dishes'])) {
        $this->parse($rest_id);
        $data['dishes'] = $this->_model->get_dishes($rest_id);
      }

      View::renderTemplate('header', $data);
      View::render('rest', $data);
      View::renderTemplate('footer', $data);
  }

  public function search_post() {
    if (isset($_REQUEST['q'])) {
      $this->search($_REQUEST['q']);
    } else {
      Url::redirect();
    }
  }

  public function search($keyword)
  {
    $data['title'] = 'חיפוש';
    $data['results'] = $this->_model->search_dishes($keyword);
    $data['keyword'] = $keyword;

    View::renderTemplate('header', $data);
    View::render('search_results', $data);
    View::renderTemplate('footer', $data);
  }

  public function parse_all() {
    ?>
<script>
var ajax = {};
ajax.x = function() {
    if (typeof XMLHttpRequest !== 'undefined') {
        return new XMLHttpRequest();
    }
    var versions = [
        "MSXML2.XmlHttp.6.0",
        "MSXML2.XmlHttp.5.0",
        "MSXML2.XmlHttp.4.0",
        "MSXML2.XmlHttp.3.0",
        "MSXML2.XmlHttp.2.0",
        "Microsoft.XmlHttp"
    ];

    var xhr;
    for(var i = 0; i < versions.length; i++) {
        try {
            xhr = new ActiveXObject(versions[i]);
            break;
        } catch (e) {
        }
    }
    return xhr;
};

ajax.send = function(url, callback, method, data, sync) {
    var x = ajax.x();
    x.open(method, url, sync);
    x.onreadystatechange = function() {
        if (x.readyState == 4) {
            callback(x.responseText)
        }
    };
    if (method == 'POST') {
        x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }
    x.send(data)
};

ajax.get = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url + (query.length ? '?' + query.join('&') : ''), callback, 'GET', null, sync)
};

ajax.post = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url, callback, 'POST', query.join('&'), sync)
};
</script><script>
var ajax = {};
ajax.x = function() {
    if (typeof XMLHttpRequest !== 'undefined') {
        return new XMLHttpRequest();
    }
    var versions = [
        "MSXML2.XmlHttp.6.0",
        "MSXML2.XmlHttp.5.0",
        "MSXML2.XmlHttp.4.0",
        "MSXML2.XmlHttp.3.0",
        "MSXML2.XmlHttp.2.0",
        "Microsoft.XmlHttp"
    ];

    var xhr;
    for(var i = 0; i < versions.length; i++) {
        try {
            xhr = new ActiveXObject(versions[i]);
            break;
        } catch (e) {
        }
    }
    return xhr;
};

ajax.send = function(url, callback, method, data, sync) {
    var x = ajax.x();
    x.open(method, url, sync);
    x.onreadystatechange = function() {
        if (x.readyState == 4) {
            callback(x.responseText)
        }
    };
    if (method == 'POST') {
        x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }
    x.send(data)
};

ajax.get = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url + (query.length ? '?' + query.join('&') : ''), callback, 'GET', null, sync)
};

ajax.post = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url, callback, 'POST', query.join('&'), sync)
};
</script>
    <?php
    $data['rests'] = $this->_model->get_restaurants();
    foreach($data['rests'] as $row){
      $url = DIR . "rests/$row->rest_id";
      echo "<script>";
      echo "ajax.get('$url', {}, function() {});";
      echo "</script>";
    }
  }

  public function parse($rest_id) {
     $data['dishes'] = $this->_model->get_dishes($rest_id);
      if (empty($data['dishes'])) {
        libxml_use_internal_errors(true);
        $url = "https://www.10bis.co.il/Restaurants/Menu/Delivery/$rest_id";
        $content = Curl::get($url);
        @$doc = new \DOMDocument();
        @$doc->loadHTML($content);
        @$xml = simplexml_import_dom($doc); // just to make xpath more simple
        @$dishes = $xml->xpath("//div[@data-dishid]");

        foreach ($dishes as $dish) {
          @$dish_id = $dish['data-dishid'];
          @$dish_title = $dish->div[1]->div->p ?: $dish->div->div->p;
          @$dish_price = $dish->div[1]->div[1] ?: $dish->div->div[1];
          @$dish_price = floatval(str_replace('₪', '', $dish_price));
          @$dish_image = $dish->div['style']; //TODO: parse this :/
          @$dish_desc = $dish['title'];
          @$dish_image = str_replace(array('background: url(', ') no-repeat center;'), '', $dish_image);
          if (!$dish_price) continue;
          $dish_data = array(
            'dish_id' => $dish_id,
            'rest_id' => $rest_id,
            'dish_price' => $dish_price,
            'dish_image' => $dish_image ?: '',
            'dish_title' => trim($dish_title) ?: '',
            'dish_desc' => trim($dish_desc) ?: ''
          );

          $this->_model->add_dish($dish_data);
        }
      }
  }

  public function ping() {
      $data['restaurants'] = $this->fetch_restaurant_info();
/*
stdClass Object
(
    [RestaurantId] => 17160
    [RestaurantName] => ×¤×™×¦×” ×”×ª×—× ×”
    [RestaurantAddress] => ×ž× ×—× ×‘×’×™×Ÿ 116 ×ª×œ ××‘×™×‘
    [RestaurantCityName] => ×ª×œ ××‘×™×‘
    [RestaurantLogoUrl] => https://d25t2285lxl5rf.cloudfront.net/images/shops/17160.png
    [RestaurantPhone] => 03-5090620
    [RestaurantCuisineList] => ××™×˜×œ×§×™, ×¡×œ×˜×™×/×¡× ×“×•×•×™×¦`×™×, ×¤×™×¦×¨×™×•×ª
    [NumOfReviews] => 5
    [ReviewsRank] => 9
    [distanceFromUser] => 0 ×ž×˜×¨×™×
    [distanceFromUserInMeters] => 0
    [IsOpenForDelivery] => 1
    [IsOpenForPickup] =>
    [MinimumOrder] => â‚ª100.00
    [MinimumPriceForOrder] => 100
    [DeliveryPrice] => ×—×™× ×
    [DeliveryPriceForOrder] => 0
    [IsKosher] =>
    [RestaurantKosher] =>
    [DeliveryRemarks] =>
    [ResGeoLocation_lon] => 34.7892544
    [ResGeoLocation_lat] => 32.0708773
    [HappyHourDiscount] =>
    [HappyHourDiscountPercent] => 0
    [deliveryChargeValueType] => 0
    [HappyHourDiscountValidityString] => ×ª×§×£ ×¢×“ 00:00
    [StartOrderURL] =>
    [ActivityHours] => 09:00 - 22:45
    [PickupActivityHours] => 00:00 - 00:00
    [DeliveryTime] =>
    [IsHappyHourActive] =>
    [IsPromotionActive] => 1
    [CompanyFlag] =>
    [IsOverPoolMin] =>
    [PoolSum] => â‚ª 0.00
    [PoolSumNumber] => 0
    [DeliveryEndTime] => 22:45
    [IsTerminalActive] =>
    [IsActiveForDelivery] => 1
    [IsActiveForPickup] => 1
    [Bookmarked] =>
    [NumberOfBookmarked] => 1
    [DiscountCouponPercent] => 5
    [CouponHasRestrictions] =>
    [HasLogo] => 1
    [ResWebsiteMode] => 1
    [Priority] => 6
    [KosherCertificateImgUrl] =>
    [IsExpressRes] =>
    [HappyHourResRulesDescription] => Array
        (
        )

    [PhoneOrdersOnlyOnPortals] =>
)

*/
      View::renderTemplate('header', $data);
      //parse data
      foreach ($data['restaurants'] as $rest) {
         $rest_id = $rest->RestaurantId;
         $rest = $this->_model->get_restaurant($rest_id);
         print_r($rest[0]);
        if ($rest->PoolSumNumber) {
          $rest_avg = $this->_model->get_restaurant_avg_delivery_time($rest_id);
          echo "<a class='btn btn-default' href='#' role='button'>";
          echo "<img src='$rest->RestaurantLogoUrl' class='img-thumbnail' alt='$row->rest_name' />";
          echo "<p>";
          echo "$rest->RestaurantId $rest->RestaurantName $rest->PoolSumNumber";
          echo "</p>";
          echo "<p>זמן הגעה ממוצע: $rest_avg</p>";
          echo "</a>";
        }
      }
//      View::render('rests', $data);
      View::renderTemplate('footer', $data);

  }

  public function delivery_report($rest_id){
    $data['rest'] = $this->_model->get_restaurant($rest_id);
    if (!$data['rest']) die('nothing was found');

// for($i=0; $i<2000; $i++) {
//     $data = array(
//       'rest_id' => rand(51,17996),
//       'user_id' => rand(100,2000),
//       'timestamp' => rand(2013, 2015) . "-" . rand(1,12) . "-" . rand(1,30) . " " . rand(11,16) . ":" . rand(0,60)
//     );

//     $this->_model->delivery_report($data);
// }
//     die('temp');
     $data = array(
      'rest_id' => $rest_id,
      'user_id' => 0
    );

    echo $this->_model->delivery_report($data);
  }
}