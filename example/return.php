<?php
define ('CTBASIC_INCLUDE', 1);
include 'settings.php';
include '../lib/CtBasicApi.php';
$ctApi = new CtBasicApi(CTBASIC_MERCHANTID, CTBASIC_APIKEY);
?>
<html>
<head>
</head>
<body>
<h1>Return URL</h1>
<?php
if ($_POST) {
    $res = $ctApi->validateHash();
    if (!$res) {
?>
    <p>The POST data could not be verified. </p>
<?php
    }
    elseif ($_POST['function'] == 'APPROVE') { ?>
    <p>Thank you for your purchase!</p>
    <table>
        <tr>
            <td>Orderid</td>
            <td><?php echo $_POST['orderid']; ?></td>
        </tr>
        <?php if ($_POST['method'] == 'CARD') {?>
        <tr>
            <td>Auktorisationskod</td>
            <td><?php echo $_POST['CARD-authcode']; ?></td>
        </tr>

        <?php } elseif ($_POST['payment_method'] == 'SWISH_E') {?>
        <tr>
            <td>SWISH Payment reference</td>
            <td><?php echo $_POST['SWISH_E-payment_reference']; ?></td>
        </tr>

        <?php } ?>
    </table>

<?php
    }
    else { ?>
    <p>The order was not paid</p>
<?php  } } else {?>
<p>No post data detected </p>
<?php } ?>

<a href="shop.php">To shop</a>

</body>
</html>



