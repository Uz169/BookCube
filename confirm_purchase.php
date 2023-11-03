<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    // The user has confirmed the purchase
    // Perform the token deduction logic here
    // Redirect the user to the PDF file or a thank you page
    header('Location: c120dc7f807d201af83eae72821ed291bdc008c088d5d12442a623f9488b5f1c/483f91ebad1e44f9d736c2b5732fa0876328327a788bd8f2083ce4bbe92f666c.pdf');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Purchase</title>
</head>
<body>
    <h1>Confirm Purchase</h1>
    <p>Are you sure you want to make this purchase?</p>
    <form method="post">
        <input type="submit" name="confirm" value="Confirm Purchase">
        <a href="javascript:history.go(-1);">Cancel</a>
    </form>
</body>
</html>
