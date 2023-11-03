<?php
include("connection.php");

// Start the session if it's not already started
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve the dynamic product_id from the URL
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

    if ($product_id !== null) {
        // Retrieve the product's price from the database
        $query = "SELECT product_price FROM products WHERE product_id = ?";
        $stmt = $con->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stmt->bind_result($product_price);
            if ($stmt->fetch()) {
                $stmt->close();

                // Check if the user has enough tokens
                $query = "SELECT virtual_tokens FROM webdata WHERE user_id = ?";
                $stmt = $con->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $stmt->bind_result($virtual_tokens);
                    if ($stmt->fetch()) {
                        if ($virtual_tokens >= $product_price) {
                            // Sufficient tokens available, deduct them
                            $stmt->close();

                            // Update the user's virtual_tokens in the database
                            $deduct_query = "UPDATE webdata SET virtual_tokens = virtual_tokens - ? WHERE user_id = ?";
                            $deduct_stmt = $con->prepare($deduct_query);

                            if ($deduct_stmt) {
                                $deduct_stmt->bind_param("ii", $product_price, $user_id);
                                $deduct_stmt->execute();
                                $deduct_stmt->close();

                                // Redirect to the appropriate PDF file based on product_id
                                if ($product_id == 1) {
                                    header("Location: book/483f91ebad1e44f9d736c2b5732fa0876328327a788bd8f2083ce4bbe92f666c.pdf");
                                } elseif ($product_id == 2) {
                                    header("Location: book/animal_farm5417.pdf");
                                } elseif ($product_id == 3) {
                                    header("Location: book/geishagiin dursamj.pdf");
                                }else {
                                    // Handle other product_id values or provide a default redirection
                                    header("Location: default.pdf");
                                }
                                exit();
                            } else {
                                echo "Error: " . $con->error;
                            }
                        } else {
                            echo "Insufficient tokens"; // Not enough tokens to purchase the product
                        }
                    }
                } else {
                    echo "Error: " . $con->error;
                }
            }
        }
    } else {
        echo "Invalid product selection";
    }
} else {
    echo "User not logged in"; // You can send an error message back to the client
}
?>
