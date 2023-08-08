<?php
session_start();
include "connection/conn.php";
if(isset($_GET['update_table']))
{
    $P_KEYS = [];
    $tbl = explode("::-::",$_GET['update_table'])[0];
    $pri_value = explode("::-::",$_GET['update_table'])[1];
    $all_val_pri = explode("::/::",$pri_value);
    $update_att = explode("::-::",$_GET['update_table'])[2];
    $sql = "show columns from $tbl where `Key` = 'PRI'";
    $result = ${$_GET['conn_var']}->query($sql);
    if($result->num_rows>0)
    {
        while($row = $result->fetch_assoc())
        {
            array_push($P_KEYS,$row['Field']);
        }
    }
    $val = trim($_GET['value']," \n\r\t\v\x00");
    $val = str_replace(":/:","&",$val);
    if($update_att == "phone")
        $val = "+".$val;
    
    $P_KEYSS = "";
    foreach($P_KEYS as $ind => $P_KEY)
    {
        $P_KEYSS .= ($P_KEYSS == "")?"`$P_KEY` = '$all_val_pri[$ind]'":"AND `$P_KEY` = '$all_val_pri[$ind]'";
    }
    $sql = "Select * from $tbl";
    $sql .= " WHERE $P_KEYSS";
    $result = ${$_GET['conn_var']}->query($sql);
    $row = $result->fetch_assoc();
    $pri_val_pair = "";
    foreach($P_KEYS as $ind => $P_KEY)
    {
        $pri_val_pair .= ($pri_val_pair == "")?"$P_KEY-$all_val_pri[$ind]":", $P_KEY-$all_val_pri[$ind]";
    }
    $updated_val = $row["$update_att"]."->".$val;
    $val = ($val != 'NULL')?"'$val'":$val;
    $sql = "UPDATE `$tbl` set `$update_att` = $val WHERE $P_KEYSS";
    if(${$_GET['conn_var']}->query($sql) === TRUE)
    {
        $sql = "INSERT INTO `dbs_edits`(`user`, `dbs`, `tbl`, `pri-value`, `att`, `value`) VALUES ('$_SESSION[username]','$_GET[dbs]','$tbl','$pri_val_pair','$update_att','$updated_val')";
        $con->query($sql);
        echo "success";
    }
    else
        echo ${$_GET['conn_var']}->error;
}
if(isset($_GET['show_table']))
{
    ?>
    <table class="table table-striped mt-3 overflow-x-auto" id="table1">
        <thead class="table-primary">
            <tr>
                <th>Tabels</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $sql = "SHOW TABLES";
    $result = ${$_GET['show_table']}->query($sql);
    if($result->num_rows>0)
        while($row = $result->fetch_assoc())
        {
            foreach($row as $r)
            echo "<tr><td>$r <button class='btn btn-primary btn-sm float-end' onclick='terms(this)' type='button' data-bs-toggle='modal' data-bs-target='#dbs_editor_terms' name='tbl' value='$r'>Open</button></td></tr>";
        }
    ?>
        </tbody>
    </table>
<?php
}
if(isset($_GET['keys']))
{
    $P_KEYS = [];
    $sql = "show columns from $_GET[keys] where `Key` = 'PRI'";
    $result = ${$_GET['conn']}->query($sql);
    if($result->num_rows>0)
    {
        while($row = $result->fetch_assoc())
            array_push($P_KEYS,$row['Field']);
    }
    $sql = "Select * from $_GET[keys] where 1 Limit 1";
    $result = ${$_GET['conn']}->query($sql);
    if($result->num_rows>0)
        while($row = $result->fetch_assoc())
        {
            echo "<div class='row'>";
            foreach($row as $att => $r_val)
            {
                $col = (in_array($att,$P_KEYS))?"outline-success":"primary";
                echo "<button type='button' class='btn btn-$col col mx-3 mb-2' onclick='addattr(this)'>$att</button>";
            }
            echo "</div>";
        }
}
?>