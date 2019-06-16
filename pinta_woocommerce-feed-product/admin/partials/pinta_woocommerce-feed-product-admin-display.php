<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

$categoties = new Pinta_woocommerce_Feed_Product_save_xml();
$list_category = $categoties->list_category();
$feed = $categoties->get_setting_feed(2);
$radio =$categoties->get_setting_feed(5);



$name_title = !empty($categoties->get_setting_feed(4))? $categoties->get_setting_feed(4):'';
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
    <?php $merchant =($radio ==="merchant")? 'checked="checked"': "" ?> 
    <?php $facebook =($radio ==="facebook")? 'checked="checked"': "" ?> 
    <?php $adwords =($radio ==="adwords")? 'checked="checked"': "" ?> 
<input type="radio" name="feed"   value="merchant" <?php echo $merchant; ?>  ><br>
  <label for="facebook"> Facebook</label>
<input type="radio" name="feed"  value="facebook" <?php echo $facebook; ?>  ><br>
  <label for="adwords"> Adwords</label>
<input type="radio" name="feed" value="adwords" <?php echo $adwords; ?>  ><br>
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
 
     
    <h1><?php _e('Create. xml file', 'PWFPL'); ?></h1>
    <input type="text" id="name" name="name" placeholder="<?php _e('Enter file name', 'PWFPL'); ?>">.xml<br>
    <input type="submit" class="button button-primary button-large button-salf" name="go" value="<?php _e('Save', 'PWFPL'); ?>">


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
            <td><a href="<?php echo $feed; ?>"><?php echo $feed; ?></a></td>
        </tr>

    <tbody id="the-list">
      </tbody>



</table>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(".g_cat").on("change",function(){
              var optionSelected = $("option:selected", this);
              var cat = optionSelected.text();
              var sel =$(this);
     

              var url ="https://tesoro-jewelry.com.ua/wp-admin/admin.php?page=pinta_feed_product&ajax=select";
              $.ajax({
                     type: "POST",
                     url: "https://tesoro-jewelry.com.ua/wp-admin/admin.php?page=pinta_feed_product&ajax=select",
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