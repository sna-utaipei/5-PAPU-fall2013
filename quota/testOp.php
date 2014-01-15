<?
    session_start();
    $backValue = $_POST['trans_data'];
    $_SESSION['op'] = $backValue;
    echo $_SESSION['op'];
?>