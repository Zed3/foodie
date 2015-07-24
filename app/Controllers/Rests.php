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

  public function update_restaurant($existing_rest_id=null) {
    $data['rests_new'] = $this->fetch_restaurant_info(1);

    //parse data
    foreach ($data['rests_new'] as $rest) {
      if ($existing_rest_id && $existing_rest_id <> $rest->RestaurantId) continue;
      $rest_id = $rest->RestaurantId;
      $rest_name = $rest->RestaurantName;
      $rest_address = $rest->RestaurantAddress;
      $rest_logo = $rest->RestaurantLogoUrl;
      $rest_exists = $this->_model->get_restaurant($rest_id);

      $rest_data = array(
        'rest_id' => $rest_id,
        'rest_name' => $rest_name,
        'rest_address' => $rest_address,
        'rest_logo' => $rest_logo,
        'rest_kosher' => (bool)$rest->IsKosher
      );

      //update existing row
      $this->_model->update_restaurant($rest_data);
    }

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
    $data['results_dishes'] = $this->_model->search_dishes($keyword);
    $data['results_restaurants'] = $this->_model->search_restaurants($keyword);
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
      $force = isset($_REQUEST['force']) ? $_REQUEST['force'] : 0;

      //get pending deliveries
      $data['deliveries'] = $this->_model->fetch_today_deliveries();
      $data['welcome_message'] = "";
      //if there are no deliveries for today, add them
      if (empty($data['deliveries'])) {
        $data['restaurants'] = $this->fetch_restaurant_info($force);
        foreach ($data['restaurants'] as $rest) {
          if (!$rest->PoolSumNumber) continue;
          $row = array(
            'rest_id' => intval($rest->RestaurantId),
            'total_delivery' => floatval($rest->PoolSumNumber)
          );
          $this->_model->add_delivery($row);
        }
      }

      foreach ($data['deliveries'] as $rest) {
        $rest->avg_delivery = $this->_model->get_restaurant_avg_delivery_time($rest->rest_id);
      }

      View::renderTemplate('header', $data);
      View::render('ping', $data);
      View::renderTemplate('footer', $data);

  }

  public function delivery_report($report_id){
     $data = array(
      'report_id' => $report_id,
      'user_id' => 0,
      'arrived' => $this->_model->now()
    );

    echo $this->_model->delivery_report($data);
  }

  public function add_favorite($user_id, $rest_id, $dish_id=null) {
    $data = array(
      'user_id' => $user_id,
      'rest_id' => $rest_id,
      'dish_id' => $dish_id
    );

    echo $this->_model->add_favorite($data);    
  }
}