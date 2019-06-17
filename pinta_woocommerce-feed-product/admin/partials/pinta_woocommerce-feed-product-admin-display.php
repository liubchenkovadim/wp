<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

$categoties = new Pinta_woocommerce_Feed_Product_save_xml();
$list_category = $categoties->list_category();
$feed = $categoties->get_setting_feed("url");

$radio =$categoties->get_setting_feed("radio");
$name = $categoties->get_setting_feed("name-title");
$name_title = !empty($categoties->get_setting_feed("name-title"))?  $name[0]['category_name']:'';

$categoties->list_category_facebook();

 

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       pinta.com.ua
 * @since      1.0.0
 *
 * @package    Pinta_woocommerce_Feed_Product
 * @subpackage Pinta_woocommerce_Feed_Product/admin/partials
 */
?>


<div  class="postbox " style="padding: 20px;">

    <h2 ><span> <?php _e('Which categories  include in the feed', 'PWFPL'); ?>
</span></h2>
    <div class="inside">
        <div class="categorydiv">


            <form action="" method="post">
                    <h1><?php _e('Enter product name to delete in xml', 'PWFPL'); ?></h1>

                <input type="text" id="name-title" name="name-title"  value="<?php echo $name_title ;?>" placeholder="<?php _e('Enter product name ', 'PWFPL'); ?>">

                <div  class="tabs-panel">
                    <?php wp_nonce_field('save_setting', 'setting_input'); ?>
                    <ul class=" form-no-clear">


                        <?php foreach ($list_category as $item) {
                            echo $item;
                        } ?>

                    </ul>

                </div>
                <div id="radio-group">
    <label for="merchant"> Merchant</label>
    <?php $merchant =($radio[0]['category_name'] ==="merchant")? 'checked="checked"': "" ?>
    <?php $facebook =($radio[0]['category_name'] ==="facebook")? 'checked="checked"': "" ?>
    <?php $adwords =($radio[0]['category_name'] ==="adwords")? 'checked="checked"': "" ?>
<input type="radio" name="radio"   value="merchant" <?php echo $merchant; ?>  ><br>
  <label for="facebook"> Facebook</label>
<input type="radio" name="radio"  value="facebook" <?php echo $facebook; ?>  ><br>
  <label for="adwords"> Adwords</label>
<input type="radio" name="radio" value="adwords" <?php echo $adwords; ?>  ><br>
   </div>
            <input type="submit" class="button button-primary button-large button-salf" name="save" value="<?php _e('Save', 'PWFPL'); ?>">
            <input type="hidden" name="save_setting" value="save">
                <div style="padding: 5px;">
                <a id="c_all"><?php _e('Choose all', 'PWFPL'); ?></a>
                    <a> | </a>
                <a id="d_all"><?php _e('Remove all', 'PWFPL'); ?></a>
        </div>
            </form>
        </div>
    </div>
 <?php
 if(!empty($adwords)){ ?>
     <h1><?php _e('Create .csv file', 'PWFPL'); ?></h1>
    <input type="text" id="name" name="name" placeholder="<?php _e('Enter file name', 'PWFPL'); ?>">.csv<br>
     <input type="hidden" name="csv" value="save">
    <input type="submit" class="button button-primary button-large button-salf" name="ttt" value="<?php _e('Save', 'PWFPL'); ?>">
     <?php
 } else { ?>
     
    <h1><?php _e('Create. xml file', 'PWFPL'); ?></h1>
    <input type="text" id="name" name="name" placeholder="<?php _e('Enter file name', 'PWFPL'); ?>">.xml<br>
    <input type="submit" class="button button-primary button-large button-salf" name="go" value="<?php _e('Save', 'PWFPL'); ?>">

<?php } ?>
</div>

<div class="meter" style="display: none">

    <span  id="meter" style="width:0%"></span>

</div>
<table class="wp-list-table widefat fixed striped posts">
    <thead>
    <tr>
        <!--<td><?php /*_e('Name feed','PWFRL');*/?></td>-->
       <th> <?php _e('Url last create feed', 'PWFPL'); ?></th>
    </tr>
        </thead>
        <tr>
            <td><a  id="url" href="<?php echo $feed[0]['category_name']; ?>"><?php echo $feed[0]['category_name']; ?></a></td>
        </tr>

    <tbody id="the-list">
      </tbody>



</table>
<script type="text/javascript">
    jQuery(document).ready(function($){
        var id ='';
        var elem = '';
        var cat = '';
        $(".choose").each(function () {
           elem = $(this);
          id =  $(this).children().find('.i_che').attr('id');
            var url ="https://tesoro-jewelry.com.ua/wp-admin/admin.php?page=pinta_feed_product&ajax=check_cat";
          /*  $.ajax({
                type: "POST",
                url: url,
                data: {id:id},
                success: function(result){
                    var data = $.parseJSON(result);
                   var k = elem.children().find(".g_cat>option")
                console.log(k);
                },
            });*/
        });
        $(".g_cat").on("change",function(){
              var optionSelected = $("option:selected", this);
              var cat = optionSelected.text();
              var sel =$(this);
     

              var url ="https://tesoro-jewelry.com.ua/wp-admin/admin.php?page=pinta_feed_product&ajax=select";
              $.ajax({
                     type: "POST",
                     url: url,
                    data: {cat:cat},
                    success: function(result){
                        var data = $.parseJSON(result);
                              var count = Object.keys(data).length;                             
                              var option ='';                                
                           for(var i=1;i < count;i++){
                              option  = new Option(data[i].category_name, data[i].value);
                                sel.siblings('.select_t').append($(option));

                            }
                    },
                });
             
    });
        });
   
</script>