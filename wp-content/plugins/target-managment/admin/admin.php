<?php
function am_add_target() {
    // check user capabilities
    //if ( !current_user_can( 'manage_options' ) OR !current_user_can('am_add_target')) {
    //    return;
    //}

    wp_enqueue_style('style');
    wp_enqueue_style('main');
    $UPDATE = false;
    ;

    if (isset($_POST['method'])) {
        global $wpdb; 

        $table_name = $wpdb->prefix . 'target';
        $query = array (
            'target_name' => $_POST['target_name'],
            'target_age' => $_POST['target_age'],
            'target_categorie' => $_POST['target_categorie'],
            'target_state' => $_POST['target_state'],
            'target_description' => $_POST['target_description'],
            'confirmed' => false
        );

        //ADD
        if ($_POST['method'] == 'ADD') {
            if($wpdb->insert($table_name,$query)) 
            $message = "You have successfully add ".$_POST['target_name'];
        } 
        //MODIFY
        else if ($_POST['method'] == 'UPDATE') {
            if ($wpdb->update($table_name, $query, array('id' => $_POST['id'])))
            $message = "You have successfully add update ".$_POST['target_name'];
        }

    }

    //Charger les donnees de pub a modifier
    if( isset($_POST) AND isset($_POST['id']) ) {
        global $UPDATE;
        global $wpdb; 
        $UPDATE = true;
        $table_name = $wpdb->prefix . 'target';
        $query = "SELECT * FROM $table_name WHERE id = ".$_POST['id'];
        $targetToModify = $wpdb->get_row($query, 'ARRAY_A');
    }
    ?>
    
    <div style="padding:30px">

    <h1 class="text-primary"><?php if($UPDATE) {?>Update <?php } else {?> Add <?php } ?>a target</h1>
    
    
    <?php
    //Afficher le message d'erreur
    if(isset($message)){
        echo "
        <div class=\"alert alert-success\" role=\"alert\">$message</div>        
        ";
    }?>
    
    <div class="wrap">
      <h1><?php esc_html( get_admin_page_title() ); ?></h1>
      <form action="" method="post">
      
        <input type="hidden" name="method" value="<?php if($UPDATE) {?>UPDATE<?php } else {?>ADD<?php } ?>">
        <?php if($UPDATE) { ?>
            <input type="hidden" name="id" value="<?php echo $targetToModify['id'] ?>">
        <?php }?>
        <div class="form-group">
            <label for="target_name">Target name: </label>
            <input type="text" name="target_name" id="target_name" class="form-control" 
            value="<?php echo $targetToModify['target_name'] ?>"> 
        </div>

        <div class="form-group">
            <label for="target_description">Target Description : </label>
            <textarea class="form-control" id="target_description" rows="3" name = "target_description"><?php echo $targetToModify['target_description'] ?></textarea>    
        </div>

        <div class="form-row">
            <div class = "form-group col-md-6">
                <label for="target_age">Target age: </label>
                <select class="form-control" id="target_age" name ="target_age">
                <?php
                    $age = json_decode(file_get_contents(plugin_dir_path(__FILE__).'age.json'),true);
                        foreach($age as $key => $value){
                    ?>
                        <option><?php echo $value['name'];?></option>
                    <?php
                    }?>
                </select>
            </div>
            <div class = "form-group col-md-6">
                <label for="target_categorie">socio-professional of target group : </label>
                <select class="form-control" id="target_categorie" name = "target_categorie">
                <?php
                $catgories = json_decode(file_get_contents(plugin_dir_path(__FILE__).'categories.json'),true);
                    foreach($catgories as $key => $value){
                ?>
                    <option><?php echo $value['name'];?></option>
                <?php
                }?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="target_state">State (departement) of target group: </label>
            <select class="form-control" id="target_state" name = "target_state">
            <?php
            $departements = json_decode(file_get_contents(plugin_dir_path(__FILE__).'departments.json'),true);
            foreach($departements  as $key => $value) {
                    ?>
                
                <option
                value = "<?php echo $value['name'] ?>"
                <?php
                if($UPDATE){
                    if($value['name']  == $targetToModify["target_state"])
                    echo 'selected';
                    }
                ?>
                >
                <?php echo $value['code'].' - '.$value['name']; ?></option>
            <?php
            }
            ?>
            </select>
        </div>
        <?php if($UPDATE) { ?>
            <button type="submit" class="btn btn-success">Update</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Add</button>
        <?php } ?>
      </form>
    </div>
    </div>

    <?php
}




function am_managment_page(){
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    global $wpdb;
    $table_name = $wpdb->prefix . 'target';
    ?>
    <div class="container" style="padding:30px;">
    <?php
        if(isset($_POST['DELETE']) && $_POST['DELETE'] == 1 ){
                $wpdb->delete( $table_name, array('id' => number_format($_POST['id'])));
            ?>
                <div class="alert alert-danger" role="alert">
                You have removed a target group!
                </div>
            <?php
            }
        

        
        if(isset($_POST['CONFIRMER']) && $_POST['CONFIRMER'] == 1 ){
            $wpdb->update( $table_name, array('confirmed' => true ), array('id' => $_POST['id']) );
        ?>
            <div class="alert alert-success" role="alert">
                You have Confirm a target group!
            </div>
        <?php
    }


    
    $sql = "SELECT * FROM $table_name WHERE confirmed is false";
    $sql_confirmed = "SELECT * FROM $table_name WHERE confirmed is true";
    $target = $wpdb->get_results($sql,'ARRAY_A');
    $target_confirmed = $wpdb->get_results($sql_confirmed,'ARRAY_A');

    wp_enqueue_style('style');
    wp_enqueue_style('main');
    wp_enqueue_style('fontawesome');

    ?>
    <h2 class = "text-info" style="margin-bottom:20px;">Unconfirmed targets</h2>
    <h6>Here you find routing targets before confirmation, you can edit them.</h6>
    <table class="table" style="margin-bottom:50px;">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Target</th>
                <th scope="col">Age</th>
                <th scope="col">Categorie</th>
                <th scope="col">State</th>
                <th scope="col">Confirmed</th>
                <?php if (current_user_can('am_confirm_target')) { ?>
                <th scope="col">Confirm</th>
                <?php }?>
                <th scope="col">Delete</th>
                <th scope="col">Update</th>               
                </tr>
            </thead>
            <tbody>
    <?php
    foreach($target as $onetarget) {
    ?>
        <tr class="bg-light">
      <th scope="row"><?php echo $onetarget['id'] ?></th>
      <td><?php echo $onetarget['target_name'] ?></td>
      <td><?php echo $onetarget['target_age'] ?></td>
      <td><?php echo $onetarget['target_categorie'] ?></td>
      <td><?php echo $onetarget['target_state'] ?></td>
      <td style="text-align: center;">
      <?php if( $onetarget['confirmed']) {?>
        <i class="fas fa-check-circle" style="color:#007E33; font-size:1.3em"></i>
      <?php } else{?>
        <i class="fas fa-times-circle" style="color:#CC0000; font-size:1.3em"></i>
      <?php } ?>
      </td>
    
        <?php if (current_user_can('am_confirm_target')) { ?>
        <td>
        <form action="" method="post">
        <input type="hidden" name="CONFIRMER" value="1">
        <input type="hidden" name="id" value= "<?php echo $onetarget['id']?>">
        <button type="submit" class="btn btn-outline-success btn-sm">Confirm</button>
        </form>
        </td>
        <?php }?>

      <td>
      <form action="" method="post">
      <input type="hidden" name="DELETE" value="1">
      <input type="hidden" name="id" value= "<?php echo $onetarget['id']?>">
      <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
      </form>
      </td>

      <td>
      <form action="<?php echo admin_url('admin.php?page=am_menu_add_update')?>" method="post">
        <input type="hidden" name="id" value= "<?php echo $onetarget['id']?>">
        <button type="submit" class="btn btn-outline-info btn-sm">Update</button>
        </form>
        </td>
        </tr>
        <?php }?>

        </tbody>
        </table>
    <h2 class = "text-success" style="margin-bottom:20px;">Confirmed targets</h2>
    <table class="table" style="margin-bottom:50px;">  
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Cible</th>
                <th scope="col">Age</th>
                <th scope="col">Categorie</th>
                <th scope="col">State</th>
                <th scope="col">Confirmed</th>
                <?php if (current_user_can('am_confirm_target')) { ?>
                <th scope="col">Generate XML</th>
                <?php }?>
                <th scope="col">Delete</th>
                <th scope="col">Update</th>               
                </tr>
            </thead>
            <tbody>
    <?php
    foreach($target_confirmed as $onetarget) {
    ?>
        <tr class="bg-light">
      <th scope="row"><?php echo $onetarget['id'] ?></th>
      <td><?php echo $onetarget['target_name'] ?></td>
      <td><?php echo $onetarget['target_age'] ?></td>
      <td><?php echo $onetarget['target_categorie'] ?></td>
      <td><?php echo $onetarget['target_state']?></td>
      <td style="text-align: center;">
      <?php if( $onetarget['confirmed']) {?>
        <i class="fas fa-check-circle" style="color:#007E33; font-size:1.3em"></i>
      <?php }?>
      </td>
    
        <?php if (current_user_can('am_generate_xml_target')) { ?>
        <td>
        <form action="" method="post">
        <input type="hidden" name="XML" value="1">
        <input type="hidden" name="id" value= "<?php echo $onetarget['id']?>">
        <button type="submit" class="btn btn-outline-success btn-sm">XML</button>
        </form>
        </td>
        <?php }?>

        <td>
        <form action="" method="post">
        <input type="hidden" name="DELETE" value="1">
        <input type="hidden" name="id" value= "<?php echo $onetarget['id']?>">
        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
        </td>

        <td>
        <form action="<?php echo admin_url('admin.php?page=am_menu_add_update')?>" method="post">
            <input type="hidden" name="id" value= "<?php echo $onetarget['id']?>">
            <button type="submit" class="btn btn-outline-info btn-sm">Update</button>
            </form>
            </td>
            </tr>
            <?php }?>

        </tbody>
        </table>        
        </div>

    <?php
}

function am_management_menu() {
    add_menu_page(
        'Target Management',
        'Target Management',
        'manage_options',
        'am_menu_parent',
        'am_managment_page',
        plugin_dir_url(__FILE__) . '../images/pub-icon.png'
    );
    
    add_submenu_page(
        'am_menu_parent',
        'Target Management',
        'Update or Add a target',
        'manage_options',
        'am_menu_add_update',
        'am_add_target'
    );
}
