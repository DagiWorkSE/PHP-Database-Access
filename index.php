<?php
session_start();
$_SESSION['username'] = 'User';
include "connection/conn.php";
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DATABASE ACCESS AND EDITOR</title>
    <meta name="description" content="DATABASE ACCESS AND EDITOR">
    <meta name="keywords" content="DATABASE EDITOR, FERGAMI">
    <meta name="author" content="DAGEM ADUGNA">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <meta property="og:title" content="DATABASE ACCESS AND EDITOR" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.fergami.com/" />
    <meta property="og:image" content="images/logo.jpg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Content Wrapper. Contains page content -->
  </head>
  <body>
<div class="content-wrapper">

  <script>
    var temp_data = "";
    var focus_id = '';
    function begin(e)
    {
        e.setAttribute("contenteditable","plaintext-only");
        e.focus();
        temp_data = e.innerHTML;
    }
    function changed(e)
    {
        e.removeAttribute("contenteditable");
        Swal.fire({
                title: "Are you sure? ",
                text: "you wish to countinue",
                icon: "warning",
                showCancelButton: true,
                buttons: true,
                buttons: ["Cancel", "Yes"]
            })
            .then((result) => {
                if (result.isConfirmed) {
                    let upd = e.innerHTML.replaceAll("&",":/:");
                    let conn_var = document.getElementById('conns').value;
                    let dbs = document.getElementById("conns").options[document.getElementById('conns').selectedIndex].innerHTML;
                    const req = new XMLHttpRequest();
                    req.onload = function(){//when the response is ready
                        if(this.responseText == 'success')
                            Swal.fire('Successful!','Update Successful','success');
                        else
                        {
                            e.innerHTML = temp_data;
                            temp_data = "";
                            Swal.fire('Failed!',this.responseText,'error');
                        }
                    }
                    req.open("GET", "ajax_update.php?update_table="+e.id+"&value="+upd+"&conn_var="+conn_var+"&dbs="+dbs);
                    req.send();
                }
                else
                {
                    e.innerHTML = temp_data;
                    temp_data = "";
                }
            });
    }
    function dbs_change(e)
    {
        const req = new XMLHttpRequest();
        req.onload = function(){//when the response is ready
            document.getElementById("db_tables").innerHTML = this.responseText;
        }
        req.open("GET", "ajax_update.php?show_table="+e.value);
        req.send();
    }
</script>
  <!-- Main content -->
  <section class="content">
      <div class="container-fluid">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
</div>
<div id ='db_tables' class="mx-auto container text-center bg-white py-2 shadow">
    <h3 class="text-center my-3 fw-bold">Manage Database Tables</h3>
    <hr>
    <select class='form-select text-primary mb-3' name='conns' id='conns' onchange="dbs_change(this)">
        <option name = 'con' value = 'con'>CMS</option>
        <?php ?>
    </select>
    <hr>
        <!-- <table class="table table-striped mt-3 overflow-x-auto" id="example1">
            <thead class="table-primary">
                <tr>
                    <th class='text-center'>Tabels</th>
                    <th>Opperation</th>
                </tr>
            </thead>
            <tbody> -->
        <?php

if(isset($_POST['conns']))
{
    $con_to_use = ${$_POST['conns']};
}
else 
    $con_to_use = $con;
        $sql = "SHOW TABLES";
        $result = $con_to_use->query($sql);
        if($result->num_rows>0)
            while($row = $result->fetch_assoc())
            {
                foreach($row as $r)
                if($r != "account")
                echo "<button class='btn btn-outline-primary my-1 text-capitalize fw-bold' onclick='terms(this)' type='button' data-toggle='modal' data-target='#dbs_editor_terms' name='tbl' value='$r' type='submit'>$r</button>
                    
                ";
                // echo "<tr><td class='text-center'>$r</td>
                // <td><button class='btn btn-primary btn-sm' onclick='terms(this)' type='button' data-toggle='modal' data-target='#dbs_editor_terms' name='tbl' value='$r' type='submit'>Open</button></td></tr>";
            }
        ?>
            <!-- </tbody>
        </table> -->
    </div>
<div class='modal fade' id='dbs_editor_terms'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h3 id='top_text' class="w-100 text-center">Conditions <span class='small text-secondary'>(optional)</span>
                <button type="button" class="btn btn-danger border-0 float-end" data-dismiss="modal">X</button></h3>
            </div>
            <div class='modal-body' id='reason_body'>
                <h5 class='text-center fw-bold' id='query'></h4>
                <div class="row">
                    <div class="row col-12">
                        <div class='text-center mx-auto mb-4 col-10'>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <button type='button' onclick="query_type(this)" class="btn nav-link active" data-toggle="tab" id='select-tab' data-target="#select_q" role="tab" aria-controls="select_q" aria-selected="true">
                                        Select Query
                                    </button>
                                </li>
                                <!-- <li class="nav-item">
                                    <button type='button' onclick="query_type(this)" class="btn nav-link" data-toggle="tab" id='update-tab' data-target="#update_q" role="tab" aria-controls="update_q" aria-selected="false">
                                        Update Query
                                    </button>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class='col-sm-12 col-md-6'>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active" id="select_q" role="tabpanel" aria-labelledby="select-tab">
                                <div class="form-floating mb-3">
                                    <input onchange="terms_update(this)" onkeyup="terms_update(this)" type="text" class="form-control" name='specific_sql' placeholder="a" id='cond_sql' onBlur="focus_id = this.id">
                                    <label for="cond_sql">Condtions <i class="text-secondary text-primary">Sample : Attribute_1 = 'value_1'</i></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input onchange="terms_update(this)" onkeyup="terms_update(this)"  type="number" class="form-control" name='limit_sql' placeholder="a" id='limit_sql' onBlur="focus_id = this.id">
                                    <label for="limit">Limit<span class="text-sm text-secondary">(optional) </span></label>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="update_q" role="tabpanel" aria-labelledby="update-tab">
                                <div class="form-floating mb-3">
                                    <input onchange="terms_update(this,'update')" onkeyup="terms_update(this,'update')" type="text" class="form-control" name='set_value' placeholder="a" id='set_sql_upd' onBlur="focus_id = this.id">
                                    <label for="cond_sql">Set Values <i class="text-secondary text-primary">Sample : Attribute_1 = 'value_1',Attribute_1 = 'value_1'</i></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input onchange="terms_update(this,'update')" onkeyup="terms_update(this,'update')" type="text" class="form-control" name='update_sql' placeholder="a" id='cond_sql_upd' onBlur="focus_id = this.id">
                                    <label for="cond_sql">Condtions <i class="text-secondary text-primary">Sample : Attribute_1 = 'value_1'</i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-12 col-md-6' id='ajax_keys'>
                        
                    </div>
                </div>
                <div class='w-100'>
                    <button class='btn btn-primary mx-auto'  id='tbl_modal' name='tbl' type='submit'>Run</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php
if(isset($_POST['conns']))
{
    $con_to_use = ${$_POST['conns']};
    $tbl = $_POST['tbl'];
    //////////////////////////////////select//////////////////////////////////////////
    if(isset($_POST['specific_sql']) && $_POST['specific_sql']!='')
    {
        $specific_sql = $_POST['specific_sql'];
    }
    if(isset($_POST['limit_sql']) && $_POST['limit_sql']!='')
    {
        $limit_sql = $_POST['limit_sql'];
    }
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////Update//////////////////////////////////////////
    if(isset($_POST['update_sql']) && $_POST['update_sql']!='')
    {
        $specific_sql = $_POST['update_sql'];
    }
    if(isset($_POST['set_value']) && $_POST['set_value']!='')
    {
        $sql_pkey = "show columns from $tbl where `Key` = 'PRI'";
        $result_pkey = $con->query($sql_pkey);
        if($result_pkey->num_rows>0)
        {
            while($row_pkey = $result_pkey->fetch_assoc())
                $P_KEY = $row_pkey['Field'];
        }
        $cond = (!isset($specific_sql) || $specific_sql == "")?'1':$specific_sql;
        $select = "SELECT * from $tbl where $cond";
        if(!isset($P_KEY) || $P_KEY == '') 
            $select = 'LIMIT 1';
        $result = $con_to_use->query($select);
        $update_query = "UPDATE $tbl SET $_POST[set_value] WHERE $cond";
        if($con_to_use->query($update_query) === TRUE)
        {
            $_SESSION['success'] = $update_query." Successfully Executed";
            while($row = $result->fetch_assoc())
            {
                $select = "SELECT * from $tbl where $cond";
                if(isset($P_KEY) && $P_KEY != '')
                {
                    $pri_val_pair = "$P_KEY-$row[$P_KEY]";
                    $select .= " AND $P_KEY = $row[$P_KEY]";
                }
                else
                {
                    $select = 'LIMIT 1';
                    $pri_val_pair = $cond;
                }
                $result_updated = $con_to_use->query($select);
                $row_upd = $result_updated->fetch_assoc();
                $updated_data=array_diff_assoc($row,$row_upd);
                $before_data=array_diff_assoc($row_upd,$row);
                foreach($before_data as $att=>$val)
                {
                    $dbs = (sizeof(explode("_",$_POST['conns']))>1)?explode("_",$_POST['conns'])[1]:$_POST['conns'];
                    if($dbs == 'conn') $dbs = 'LPMS';
                    $updated_val = $before_data[$att]."->".$updated_data[$att];
                    $sql = "INSERT INTO `dbs_edits`(`user`, `dbs`, `tbl`, `pri-value`, `att`, `value`) VALUES 
                    ('$_SESSION[username]','$dbs','$tbl',\"$pri_val_pair\",'$att','$updated_val')";
                    $con->query($sql);
                }
                    
            }
        }
        else
        {
            $_SESSION['failed_attempt'] = $update_query." Failed (".$con_to_use->error.")";
        }
    }
    //////////////////////////////////////////////////////////////////////////////////
}
else
{
    $con_to_use = $con;
    $tbl = "catagory";
}
?>
<div class='card col-11 mt-3 mx-auto py-4 px-2'>
<!-- <h3 class="text-center my-3">Manage Data of `<?= $tbl?>` Table</h3> -->
<table class="table table-striped mt-3 overflow-x-auto" id="example1">
    <thead>
        <tr>
<?php
$attributes = [];
$sql = "Select * from $tbl where 1 Limit 1";
$result = $con_to_use->query($sql);
if($result->num_rows>0)
    while($row = $result->fetch_assoc())
    {
        foreach($row as $att => $r_val)
        {
            if($att != "password" && $att != "creation_date")
            {
                array_push($attributes,$att);
                echo "<th>$att</th>";
            }
        }
    }
?>
</tr>
    </thead>
    <tbody>
<?php
$P_KEYS =[];
$forbiden = ['log','dbs_edits'];
$sql = "show columns from $tbl where `Key` = 'PRI'";
$result = $con_to_use->query($sql);
if($result->num_rows>0 && !in_array($tbl,$forbiden))
{
    while($row = $result->fetch_assoc())
        array_push($P_KEYS,$row['Field']);
    // $P_KEY = $row['Field'];
    $editable = " onClick='begin(this)' onFocusout='changed(this)'";
}
else
{
    $editable = "";
    $P_KEY = "";
}
$sql = "Select * from $tbl";
$sql .= (isset($specific_sql))?" Where ".$specific_sql:"";
$sql .= (isset($limit_sql))?" Limit ".$limit_sql:"";
$result = $con_to_use->query($sql);
if($result->num_rows>0)
    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
            foreach($attributes as $att)
            {
                $P_KEYSS = "";
                if(isset($P_KEYS))
                foreach($P_KEYS as $P_KEY)
                {
                    $P_KEYSS .= ($P_KEYSS == "")?$row["$P_KEY"]:"::/::".$row["$P_KEY"];
                }
                // if($att != "password" && $att != "creation_date")
                echo "<td><div class='editable_stuff' style='min-height:10px' id='".$tbl."::-::".$P_KEYSS."::-::".$att."' $editable>$row[$att]</div></td>";
            }
        echo "</tr>";
    }
?>
    </tbody>
</table>
</div>
<script>
    <?PHP 
    if(isset($_POST['conns']))
    {?>
        if(document.getElementsByName('<?php echo $_POST['conns']?>').length == 0)
        {
            let name_conn = ("<?php echo $_POST['conns']?>".split("_").length>1)?"<?php echo $_POST['conns']?>".split("_")[1]:"<?php echo $_POST['conns']?>";
            var option = document.createElement("option");
            option.text = name_conn;
            option.name = "<?php echo $_POST['conns']?>";
            option.value = "<?php echo $_POST['conns']?>";
            document.getElementById('conns').add(option);
        }
        document.getElementById('conns').value = '<?php echo $_POST['conns']?>';
        <?php
    }
    ?>
    var temp_q;
    function addattr(e)
    {
        let input = document.getElementById(focus_id);
        let position_insert = input.selectionStart;
        if(position_insert == 0)
        {
            input.value = "`"+e.innerHTML+"`"+input.value;
        }
        else
        {
            let new_str = input.value.slice(0,position_insert)+"`"+e.innerHTML+"`"+input.value.slice(position_insert);
            input.value = new_str;
        }
        input.focus();
        let pos_caret = position_insert + e.innerHTML.length+2;
        input.setSelectionRange(pos_caret, pos_caret);
    }
    function terms(e)
    {
        document.getElementById("query").innerHTML = "Select * from "+e.value;
        document.getElementById("tbl_modal").value = e.value;
        let con = document.getElementById("conns").value;
        temp_q = document.getElementById("query").innerHTML;
        const req = new XMLHttpRequest();
        req.onload = function(){//when the response is ready
        document.getElementById("cond_sql").value="";
        document.getElementById("limit_sql").value="";
            document.getElementById("ajax_keys").innerHTML=this.responseText;
        }
        req.open("GET", "ajax_update.php?keys="+e.value+"&conn="+con);
        req.send();
    }
    function terms_update(e,type='')
    {
        if(type != '')
        {
            let cond = document.getElementById("cond_sql_upd");
            let update = document.getElementById("set_sql_upd");
            let tbl_name = document.getElementById("tbl_modal").value;
            let new_temp = 'Update '+tbl_name+' set ';
            if(update.value != "") 
            {
                new_temp += update.value;
            }
            let conditions = "";
            if(cond.value != "") 
            {
                conditions += " Where "+cond.value;
            }
            else
                conditions = " Where 1";
            document.getElementById("query").innerHTML = new_temp+conditions;
        }
        else
        {
            let conditions = "";
            let cond = document.getElementById("cond_sql");
            let limit_sql = document.getElementById("limit_sql");
            if(cond.value != "") 
            {
                conditions += " Where "+cond.value;
            }
            if(limit_sql.value != "") 
            {
                conditions += " LIMIT "+limit_sql.value;
            }
            document.getElementById("query").innerHTML = temp_q+conditions;
        }
    }
    function query_type(e)
    {
        focus_id = '';
        let btn = document.getElementById('tbl_modal');
        if(e.id == 'select-tab')
        {
            btn.removeAttribute('onclick');
            btn.type = 'submit';
            document.getElementById('set_sql_upd').value = "";
            document.getElementById('cond_sql_upd').value = "";
        }
        else
        {
            btn.setAttribute('onclick','prompt_confirmation(this)');
            btn.type = 'button';
            document.getElementById('specific_sql').value = "";
            document.getElementById('limit_sql').value = "";
        }
    }
</script>
</div>
</section>
</div>
<script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/sweetalert-dev.js"></script>
    <script src="assets/sweetalert.css"></script> 
    <script src="assets/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>
</html>