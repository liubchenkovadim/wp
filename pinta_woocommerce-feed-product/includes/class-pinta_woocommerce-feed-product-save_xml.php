<?php


class Pinta_woocommerce_Feed_Product_save_xml
{

    private $data = array();


    public function list_category()
    {
        $save_list = $this->get_setting_feed(1);
        if (empty($save_list)) {
            $save_list = array();
        }

        $args = array('type' => 'product', 'taxonomy' => 'product_cat');
        $categories = get_categories($args);
        $list = [];

        $list[] = '<table>';
        foreach ($categories as $category) {
            $value = '';

            if (!empty($save_list)) {
                if (in_array($category->name, $save_list) == true) {
                    $value = 'value = "1" checked';
                }
            }
$name =$category->name;

            $list[] = '<li class="choose"><label>
          <input type="checkbox" id="' . $category->name . '" name="category_list[' . $category->name . ']" ' . $value . ' > ' . $category->name . '</label>'.$this->cat_gogle_first($name).'
         </li>';

        }
        $list[] = '</table>';

        return $list;
    }

    public function select_xml($cat)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_google_category';

        $sql = "SELECT `category_name`, `value` FROM ".$table." WHERE category_list='".$cat."' ";
       
         $list = $wpdb->get_results($sql,ARRAY_A); 
         unset($list[0]);
         $res = json_encode($list);
         echo $res;

         

    }

    public function cat_gogle_first($name)
    {
        $first_list = $this->list_category_facebook();
        $select = "<select class='g_cat' >";
           $select .= "<option selected value='0' >--select--</option>";

            foreach ($first_list as $value) {
                $select .= "<option  value=".$value['value'].">".$value['category_list']."</option>";
            }
            $select .= "</select>
<select class='select_t' name='category_gogle[".$name."]' ><option  value='0' >--select--</option></select>
            ";
            return $select;
    }

   public function list_category_facebook()
    {
        global $wpdb;
        $setting = $this->get_setting_feed(5);
        if($setting === "facebook"){
             $table = $wpdb->prefix . 'pinta_feed_product_google_category';
             $sql = "SELECT `category_list`,`value` FROM ".$table." WHERE 1 GROUP BY category_list";
            $first_list = $wpdb->get_results($sql,ARRAY_A); 
            
          return $first_list;

        } else {
            return;
        }
    }
    public function generate_category()
    {
         global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_google_category';
        $url ='https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt';
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, 0);       

$page = curl_exec($ch); 
curl_close($ch); 
$google_category =explode("\n", $page);
unset($google_category[0]);
$newres =array_pop($google_category);
$sql = "INSERT INTO ".$table." ( `value`,`category_list`, `category_name`) VALUES ";
foreach ($google_category as $value) {
    $str = explode("-",$value);
    $a =$str[1];
    $list = explode(">", $str[1]);
    $k =$list[0];
    $sql .= "(".$str[0].",\"".$k."\",\"".$a."\"),";
   
}
$sql2 = mb_substr($sql, 0, -1);


        $wpdb->query($sql2);    

// $wpdb->insert($table, ['id' => 1,'category'=>"1212121"]);
        return;
    }

    public function save_xml()
    {


        $list = $this->get_setting_feed(1);

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
            $entry->appendChild($dom->createElement('g:brand', $data['brend']));
            $entry->appendChild($dom->createElement('g:type', $data['type']));


            $feed->appendChild($entry);
        

        }


        $dom->formatOutput = true;
        $dom->save($name . ".xml"); // Сохраняем полученный XML-документ в файл
        $path = ABSPATH . '/wp-admin/' . $name . '.xml';
        if (file_exists($path)) {
            $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/wp-admin/' . $name . '.xml';

            $this->save_setting($url, 2);
            $this->save_setting(true, 3);

        }

    }

    public function save_setting($post, $id = 1)
    {

        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_setting';
       // if($wpdb->select($table, ['id' => 5))
         $wpdb->delete($table, ['id' => 5]);
        $wpdb->insert($table, ['id' => 5,'category'=>$post['feed']]);
        if ((!empty($post['name-title']))&& (trim($post['name-title']) !== '')) {
         $list['id'] = 4;
          $list['category'] = $post['name-title'];
          
        $wpdb->insert($table, $list);

        } else {
 $wpdb->delete($table, ['id' => 4]);
        }

        $list['id'] = $id;
        if ($id == 1) {

            if (!empty($post['category_list'])) {
 var_dump($post);
                foreach ($post['category_list'] as $key => $item) {

                    if (($item == '1') ||($item == 'on')) {
                        $arr[] = sanitize_text_field($key);
                    }

                }

                $list['ids'] = count($this->get_product_id($arr));
                $list['category'] = serialize($arr);


            }
        } else {
            $list['category'] = sanitize_text_field($post);

        }


        $wpdb->delete($table, ['id' => $id]);
        $wpdb->insert($table, $list);


    }

    public function get_setting_feed($id = 1)
    {
        $result = [];
        global $wpdb;
        $table = $wpdb->prefix . 'pinta_feed_product_setting';
        $t = "SELECT category,ids FROM $table WHERE id=$id ";

        $list = $wpdb->get_results($t);
        if (!empty($list)) {

            if ($id == 1) {

                $list_arr = unserialize($list[0]->category);
                if ($list_arr !== null) {

                    if ($list_arr === false) {


                        return null;
                    } else {
                        foreach ($list_arr as $key => $item) {

                            $result[$key] = $item;

                        }
                    }
                } else {
                    return null;
                }
            } else {
                $result = $list[0]->category;
            }

            return $result;
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
        $this->save_setting(false, 3);
        $this->save_setting(false, 2);
        $cat_list = $this->get_setting_feed(1);
       


        $products = $this->get_product_id($cat_list);


        foreach ($products as $product) {
            $false = true;
            $id = $product->id;
            $category = wp_get_post_terms($id, 'product_cat', array("fields" => "names"));

            if (in_array($category[0], $cat_list) or (empty($category))) {
               
                if($this->check_title($id)){
                $data['category'] = $category[0];


                $data['id'] = $product->id;
                $data['link'] = $product->link;
                $product_s = wc_get_product($id);
                $data['name'] = $product_s->get_title();
                $data['description'] = $product_s->get_description();
                $data['sku'] = $product_s->get_sku();


                $data['price'] = $product_s->get_price();
                $data['image'] = wp_get_attachment_url($product_s->get_image_id());

                /* $category = wp_get_post_terms($id, 'product_cat', array("fields" => "names"));
                 if (!empty($category)) {
                     foreach ($category as $cat) {
                         $data['category'][] = $cat;
                     }
                 }*/
                $data['brend'] = $product_s->get_attribute('pa_brend');
                $data['type'] = $product_s->get_attribute('pa_tip');


                $data['stock'] = $product_s->get_availability();
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


    public function obj_start()
    {


        return $this->greateData();
    }

    public function check_title($id){
         $name_title = !empty($this->get_setting_feed(4))? $this->get_setting_feed(4):'';
        
         if($name_title === ''){
            return true;
         } else {
             $search = "#".mb_strtolower($name_title,'UTF-8')."#";
                             $product_s = wc_get_product($id);

             $str = mb_strtolower($product_s->get_title(),'UTF-8');
            if(!preg_match($search, $str)){
                return true;

            } else {
                return false;
            }

         }

    }
}