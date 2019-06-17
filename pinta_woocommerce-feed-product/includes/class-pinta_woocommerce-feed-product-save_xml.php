<?php


class Pinta_woocommerce_Feed_Product_save_xml
{

    private $data = array();


    public function list_category()
    {
        $save_list = $this->get_setting_feed("category");
        if (empty($save_list)) {
            $save_list = array();
        }

        $args = array('type' => 'product', 'taxonomy' => 'product_cat');
        $categories = get_categories($args);
        $list = [];

        $list[] = '<table>';
        foreach ($categories as $category) {
            $value = '';

            foreach ($save_list as $val){

                    if ($category->name == $val["category_name"])  {
                        $value = 'value = "1" checked';
                        break;
                    }
                }


            $name = $category->name;

            $list[] = '<li class="choose"><label>
          <input type="checkbox" class="i_che" id="' . $category->name . '" name="category_list[' . $category->name . ']" ' . $value . ' > ' . $category->name . '</label>' . $this->cat_gogle_first($name) . '
         </li>';

        }
        $list[] = '</table>';

        return $list;
    }

    public function select_xml($cat)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_google_category';

        $sql = "SELECT `category_name`, `value` FROM " . $table . " WHERE category_list='" . $cat . "' ";

        $list = $wpdb->get_results($sql, ARRAY_A);
        unset($list[0]);
        $res = json_encode($list);
        echo $res;


    }

    public function cat_gogle_first($name)
    {
        $setting = $this->get_setting_feed("radio");

        if ($setting[0]['category_name'] === "facebook") {
            $first_list = $this->list_category_facebook();

            $select = "<select class='g_cat' >";
            $select .= "<option selected value='0' >--select--</option>";

            foreach ($first_list as $value) {
                $select .= "<option  value=" . $value['value'] . ">" . $value['category_list'] . "</option>";
            }
            $select .= "</select>
<select class='select_t' name='category_google[" . $name . "]' data-category='" . $name . "'><option  value='0' >--select--</option></select>
            ";
            return $select;
        }
        return '';
    }
    public function list_category_facebook()
    {
        global $wpdb;
        $setting = $this->get_setting_feed("radio");

        if ($setting[0]['category_name'] === "facebook") {
            $table = $wpdb->prefix . 'pinta_feed_product_google_category';
            $sql = "SELECT `category_list`,`value` FROM " . $table . " WHERE 1 GROUP BY category_list";

            $first_list = $wpdb->get_results($sql, ARRAY_A);


            return $first_list;

        } else {
            return;
        }
    }

    public function generate_category()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_google_category';
        $url = 'https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);

        $page = curl_exec($ch);
        curl_close($ch);
        $google_category = explode("\n", $page);
        unset($google_category[0]);
        $newres = array_pop($google_category);
        $sql = "INSERT INTO " . $table . " ( `value`,`category_list`, `category_name`) VALUES ";
        foreach ($google_category as $value) {
            $str = explode("-", $value);
            $a = $str[1];
            $list = explode(">", $str[1]);
            $k = $list[0];
            $sql .= "(" . $str[0] . ",\"" . $k . "\",\"" . $a . "\"),";

        }
        $sql2 = mb_substr($sql, 0, -1);


        $wpdb->query($sql2);

// $wpdb->insert($table, ['id' => 1,'category'=>"1212121"]);
        return;
    }

    public function  save_csv()
    {



        $name = $_POST['name'];
   
        $this->save_setting(false, "url");
        $this->save_setting(false, 'on');
        $feed = $this->get_setting_feed('radio');
        if($feed[0]['category_name'] == "adwords"){
            $cat_list2 = $this->get_setting_feed("category");
            $str = "Page URL, Custom label".PHP_EOL;
            foreach ($cat_list2 as $val){
                $cat_list[]= $val['category_name'];
            }
            $products = $this->get_product_id($cat_list);

            foreach ($products as $product) {
                $false = true;
                $id = $product->id;
                $category = wp_get_post_terms($id, 'product_cat', array("fields" => "names"));

                if (in_array($category[0], $cat_list) or (empty($category))) {

                    $product_s = wc_get_product($product->id);
                    if(!preg_match("#Roberto#",$product_s->get_title())){
                        $str .= $product->link.",".$product_s->get_title().PHP_EOL;
                    }

                }
            }
            header('Content-type: text/plain');
            header('Content-Disposition: attachment; filename="'.$name.'.csv"');
            print $str;
            return ;
        
    }
        
      
    }

    public function save_xml()
    {


        $list = $this->get_setting_feed('category');

        $datas = $this->greateData();


        $name = $_POST['name'];
        $dom = new domDocument("1.0", "utf-8");

        $feed = $dom->createElement("feed"); // Создаём корневой элемент
        $feed->setAttribute("xmlns", "http://www.w3.org/2005/Atom");
        $feed->setAttribute("xmlns:g", "http://base.google.com/ns/1.0");

        $dom->appendChild($feed);


        $title = $dom->createElement('title', 'fidproduct');
        $link = $dom->createElement('link');
        $link->setAttribute('rel', 'self');
        $link->setAttribute('href', get_bloginfo('url'));
        $update = $dom->createElement('update', date("m-d-y H:m:s"));
        $feed->appendChild($title);
        $feed->appendChild($link);
        $feed->appendChild($update);
        $feed->appendChild($dom->createElement('id', '00000001'));


        foreach ($datas as $data) {

            $entry = $dom->createElement('entry');
            $entry->appendChild($dom->createElement('g:id', $data['id']));


            $entry->appendChild($dom->createElement('g:title', preg_replace('%&%', 'AND ', $data['name'])));

            $entry->appendChild($dom->createElement('g:description', '&lt;em&gt;' . preg_replace('%&%', 'AND ', $data['description']) . '&lt;/em&gt;'));
            $entry->appendChild($dom->createElement('g:category', $data['category']));
            $entry->appendChild($dom->createElement('g:link', $data['link']));
            $entry->appendChild($dom->createElement('g:image_link', $data['image']));
            $entry->appendChild($dom->createElement('g:price', $data['price']));
            $entry->appendChild($dom->createElement('g:brand', $data['brand']));
            $entry->appendChild($dom->createElement('g:type', $data['type']));

            if(!empty($data['google_product_category'])){
                $shipping =$dom->createElement("g:shipping");
                $entry->appendChild($dom->createElement('g:condition', "new"));
                $shipping->appendChild($dom->createElement('g:country', "UA"));
                $shipping->appendChild($dom->createElement('g:service', "free_shipping"));
                $entry->appendChild($shipping);
                $entry->appendChild($dom->createElement('g:google_product_category', $data['google_product_category']));
            }

            $feed->appendChild($entry);

        }


        $dom->formatOutput = true;
        var_dump($name);
        $dom->save($name . ".xml"); // Сохраняем полученный XML-документ в файл
        $path = ABSPATH . '/wp-admin/' . $name . '.xml';
        if (file_exists($path)) {
            $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/wp-admin/' . $name . '.xml';

            $this->save_setting($url, "url");
            $this->save_setting(true, "on");

        }

    }

    public function save_setting($post, $key = 'category')
    {

        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_setting';
        if(($key == 'url') || ($key == 'on')){
            $k ="SELECT `id` FROM ".$table." WHERE `key`='".$key."'";
            $res1 = $wpdb->get_row($k,ARRAY_A);

            if(empty($res1)){
                $s= "INSERT INTO ".$table." ( `category_name`, `key`) VALUES ('".$post."','".$key."')";

                $wpdb->query($s);
            } else {
                $l ="UPDATE ".$table." SET `category_name`='".$post."' WHERE `id`=".$res1['id']." ";
                $wpdb->query($l);
            }
            return;
        }

        if (is_array($post['category_list'])) {
                $wpdb->delete($table,["key"=>'category']);


            foreach ($post['category_list'] as $keys=>$val){
                if(($val == 1) || ($val == 'on')){

                    $list['category_name'] = $keys;
                    $list['key'] = $key;
                    $list['category-google'] = $post['category_google'][$keys];
                }
                $k ="SELECT `id` FROM ".$table." WHERE `key`='".$key."' AND `category_name`='".$keys."' ";
                $res3 = $wpdb->get_row($k,ARRAY_A);
                if(empty($res3)){
                    $s= "INSERT INTO ".$table." ( `category_name`, `key`) VALUES ('".$keys."','".$key."')";

                    $wpdb->query($s);
                } else {
                    $l ="UPDATE ".$table." SET `category_name`='".$keys."' WHERE `id`=".$res3['id']." ";
                    $wpdb->query($l);
                }

            }

        }

        if(!empty($post['radio'])) {

            $key = 'radio';
            $k ="SELECT `id` FROM ".$table." WHERE `key`='".$key."'";
            $resr = $wpdb->get_row($k,ARRAY_A);


            if(empty($resr['id'])){

                $s= "INSERT INTO ".$table." ( `category_name`, `key`) VALUES ('".$post['radio']."','".$key."')";

                $wpdb->query($s);
            } else {
                $l ="UPDATE ".$table." SET `category_name`='".$post['radio']."' WHERE id=".$resr['id']." ";
                $wpdb->query($l);
            }


        }
        if(!empty($post['name-title'])) {
            $key = 'name-title';
            $k ="SELECT `id` FROM ".$table." WHERE `key`='".$key."'  ";
            $res4 = $wpdb->get_row($k,ARRAY_A);
            if(empty($res4)){
                $s= "INSERT INTO ".$table." ( `category_name`, `key`) VALUES ('".$post['name-title']."','".$key."')";

                $wpdb->query($s);
            } else {
                $l ="UPDATE ".$table." SET `category_name`='".$post['name-title']."' WHERE `id`=".$res3['id']." ";
                $wpdb->query($l);
            }
            $wpdb->delete($table, ['key' => $key]);
            $wpdb->insert($table, ['category_name'=>$post,'key'=>$key]);
        } else {
           // $wpdb->delete($table, ['key' => $key]);
        }
      /*  if(!empty($post['name-title'])) {
            $key = 'name-title';

            $wpdb->delete($table, ['key' => $key]);
            $wpdb->insert($table, ['category_name'=>$post,'key'=>$key]);
        }*/



    }

    public function get_setting_feed($key ="")
    {
        $result = [];
        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_setting';
        $t = "SELECT * FROM ".$table." WHERE `key`='".$key."'  ";


        $list = $wpdb->get_results($t,ARRAY_A);

        if (!empty($list)) {

            return $list;
        }
        return null;

    }

    public function get_product_id($data = null)
    {
        global $wpdb;
        $result = [];
        $table = $wpdb->prefix . 'posts';
        /* if($data == null){*/
        $t = "SELECT  $table.ID as id,$table.guid AS link  FROM $table

            
            WHERE 1=1 AND $table.post_type = 'product' AND $table.post_status = 'publish' 
           
";

        $result = $wpdb->get_results($t);
        /*} else {
            $t = "SELECT  $table.ID as id,$table.guid AS link,$table.post_excerpt  FROM $table 

            
            WHERE 1=1 AND $table.post_type = 'product' AND $table.post_status = 'publish'";
            foreach ($data as $item){
                $c = ' AND '.$table.'.post_excerpt="'.$item.'"';
                $arr = $wpdb->get_results($t.$c);
                 $result = array_merge($result,$arr);
            }

        }*/


        return $result;


    }


    public function greateData()
    {
        $this->save_setting(false, "url");
        $this->save_setting(false, 'on');
        $feed = $this->get_setting_feed('radio');
        $cat_list2 = $this->get_setting_feed("category");

        foreach ($cat_list2 as $val){
            $cat_list[]= $val['category_name'];
        }
        $products = $this->get_product_id($cat_list);

        foreach ($products as $product) {
            $false = true;
            $id = $product->id;
            $category = wp_get_post_terms($id, 'product_cat', array("fields" => "names"));

            if (in_array($category[0], $cat_list) or (empty($category))) {

                if ($this->check_title($id)) {
                    $data['category'] = $category[0];


                    $data['id'] = $product->id;
                    $data['link'] = $product->link;
                    $product_s = wc_get_product($id);
                    $data['name'] = $product_s->get_title();
                    $data['description'] = $product_s->get_description();
                    $data['sku'] = $product_s->get_sku();


                    $data['price'] = $product_s->get_price();
                    $data['image'] = wp_get_attachment_url($product_s->get_image_id());

                    if($feed[0]['category_name'] == 'facebook'){
                        $data['google_product_category'] = $this->check_cat($category[0]);

                    }
                    /* $category = wp_get_post_terms($id, 'product_cat', array("fields" => "names"));
                     if (!empty($category)) {
                         foreach ($category as $cat) {
                             $data['category'][] = $cat;
                         }
                     }*/
                    $data['brand'] = $product_s->get_attribute('pa_brend');
                    $data['type'] = $product_s->get_attribute('pa_tip');

                    $ps =$product_s->get_availability();
                    $data['stock'] = $ps['class'];
                    // $data['attr'] = $product_s->get_attributes();
                    $res[] = $data;
                }
            }

        }
        /*  $file = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/copy.txt';
          $fp =fopen($file,'a+');

          $string = '';
              foreach ($res as  $arr){
                  foreach ($arr as $key => $item) {
                      $string .= $key . "---" . $item . '\n';
                  }
                  $string .= '\n';
              }

          fwrite($fp,$string);
          fclose($fp);
              echo 'ok';
          exit;*/
        /*  setcookie('data_feed', serialize($res), time()+3600);
        echo 'ok';*/


        return $res;
    }



    public function check_cat($cat,$ajax = false)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_setting';
        $s ="SELECT `category-google`,`category_name` FROM ".$table."  WHERE `category_name`='".$cat."' ";
        $res = $wpdb->get_row($s,ARRAY_A);
        $table2 =$wpdb->prefix .'pinta_feed_product_google_category';

        $k = "SELECT * FROM ".$table2."  WHERE `value`=".$res['category-google']." ";
        $res2 = $wpdb->get_row($k,ARRAY_A);
        if($ajax){
            echo json_encode($res2);
        } else {
            return $res['category-google'];
        }
    return;
    }

    public function obj_start()
    {


        return $this->greateData();
    }

    public function check_title($id)
    {
        $name_title = !empty($this->get_setting_feed("name-title")) ? $this->get_setting_feed("name-title") : '';

        if ($name_title[0]['category_name'] === '') {
            return true;
        } else {
            $name = $name_title[0]['category_name'];

            $search = "#" . mb_strtolower($name, 'UTF-8') . "#";
            $product_s = wc_get_product($id);

            $str = mb_strtolower($product_s->get_title(), 'UTF-8');
            if (!preg_match($search, $str)) {
                return true;

            } else {
                return false;
            }

        }

    }
}