<form method='post' action='<?php echo $transactionURL; ?>' name='f1'>
<?php
    foreach($paytmParams as $name => $value) {
        echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
    }
?>
</form>
<script type="text/javascript">
document.f1.submit();
</script>