<?php
include_once ("../DB/config.php");

if(isset($_POST['update'])) {  
    $id = $_POST['id'];
    $stateid = $_POST['stateid'];
    $bizstype = $_POST['bizstype'];
    $lcid = $_POST['lcid'];
    $opsname = $_POST['operatorname'];
    $ownername = $_POST['ownername'];
    $status = $_POST['status'];
    $yearsigned = $_POST['yearsigned'];
    $datesigned = $_POST['datesigned'];
    $dateoperated = $_POST['dateoperated'];
    $tlcppackage = $_POST['tlcppackage'];
    $annuallicense = $_POST['annuallicense'];
    $eduemail = $_POST['eduemail'];
    $kindername = $_POST['kindername'];
    $kindernohp = $_POST['kindernohp'];
    $noblock = $_POST['noblock'];
    $street = $_POST['street'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $type = $_POST['type'];
    $ownernohp = $_POST['ownernohp'];
    $opsaddress= $_POST['operatoraddress'];

    $result = mysqli_query($conn, "UPDATE lcdetails SET id='$id',stateid='$stateid',bizstype='$bizstype',lcid='$lcid',operatorname='$opsname',ownername='$ownername',status='$status',
    yearsigned='$yearsigned',datesigned='$datesigned',dateoperated='$dateoperated',tlcppackage='$tlcppackage',annuallicense='$annuallicense',eduemail='$eduemail',kindername='$kindername',kindernohp='$kindernohp',noblock='$noblock',street='$street',postcode='$postcode',city='$city', state='$state',type='$type',ownernohp='$ownernohp',operatoraddress='$opsaddress' 
    WHERE id=$id");
    // $sql = "UPDATE lcdetails (id, stateid, bizstype, lcid, operatorname, ownername, status, yearsigned, datesigned, dateoperated, tlcppackage, annuallicense, eduemail, kindername, kindernohop, noblock, street, postcode, city, type, ownernohp, operatoraddress)
    // VALUES ('$id', '$stateid', '$bizstype', '$lcid', '$opsname', '$ownername', '$status', '$yearsigned', '$datesigned', '$dateoperated', '$tlcppackage', '$annuallicense', '$eduemail', '$kindername', '$kindernohp', '$noblock', '$street', '$postcode', '$city', '$type', '$ownernohp', '$opsaddress')"; 
    if ($result){
        echo "<script>alert('SUCCESFULL UPDATE')</script>";
        echo "<script>window.location='../../tlcp-data.php'</script>";
    }else {
        echo "<script>alert('SORRY, YOU FAILED..TRY AGAIN! :( ')</script>";
        echo "<script>window.location='tlcp-update-form.php'</script>";
    }
}
// $result = mysqli_query($conn, "UPDATE lcdetails SET id='$id',stateid='$stateid',bizstype='$bizstype',lcid='$lcid',operatorname='$opsname',ownername='$ownername',status='$status',
// yearsigned='$yearsigned',datesigned='$datesigned',dateoperated='$dateoperated',tlcppackage='$tlcppackage',annuallicense='$annuallicense',eduemail='$eduemail',kindername='$kindername',kindernohp='$kindernohp',noblock='$noblock',street='$street',postcode='$postcode',city='$city',type='$type',ownernohp='$ownernohp',operatoraddress='$opsname' 
// WHERE id=$id");
?>