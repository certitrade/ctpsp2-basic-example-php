<?php
	define ('CTBASIC_INCLUDE', 1);
	include 'settings.php';
	include '../lib/CtBasicApi.php';

	if (isset($_POST['post_form'])) {
	    $ctApi = new CtBasicApi(CTBASIC_MERCHANTID, CTBASIC_APIKEY);
	    $ctApi->setParameter("return_url", CTBASIC_RETURNURL);
	    $ctApi->setParameter("callback_url", CTBASIC_CALLBACKURL);

	    $ctApi->setData($_POST);
	    $form = $ctApi->getRedirection('test');
	    print $form;
	    exit();
	}

?>
<html>
<head>
<body>
<h1>CT Basic Demo</h1>
<form id="shopform" action="shop.php" method="post">
<table>
<tr>
    <td>Amount</td>
    <td><input type="text" name="amount" value="5.00" /></td>
</tr>
<tr>
    <td>Currency</td>
    <td><input type="text" name="currency" value="SEK" /></td>
</tr>
<tr>
    <td>Orderid</td>
    <td><input type="text" name="orderid" value="<?php echo date("YmdHis"); ?>" /></td>
</tr>
<tr>
    <td>Customer phone</td>
    <td><input type="text" name="cust_phone" value="" /></td>
</tr>
<tr>
    <td>Customer email</td>
    <td><input type="text" name="cust_email" value="" /></td>
</tr>
<tr>
    <td>Payment method</td>
    <td>
        <select name="payment_method">
           <option value="">V&auml;lj i betalf&ouml;nster</option>
           <option value="CARD">Kort</option>
           <option value="SWISH_E">Swish</option>
        </select>
</tr>

</table>
<br />
   <input type="submit" name="post_form" value="Pay" />
</form>

</body>
</html>