<?php
function increasevirtual_tokens($user_id, $amount) {
    global $con;

    $query = "UPDATE webdata SET virtual_tokens = virtual_tokens + ? WHERE user_id = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ii", $amount, $user_id);
        $stmt->execute();
    } else {
        die("Error: " . $con->error);
    }
}
?>
