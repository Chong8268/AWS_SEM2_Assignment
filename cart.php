<?php
include 'header.php';
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];

$stmt = $conn->prepare("
    SELECT
        ci.ItemsID,
        ci.ProductID,
        ci.quantity,
        ci.unit_price,
        p.name,
        p.ImageURL,
        p.stock_quantity
    FROM cartitems ci
    JOIN cart c ON c.CartID = ci.CartID
    JOIN product p ON p.ProductID = ci.ProductID
    WHERE c.CustomerID = ?
");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$result = $stmt->get_result();


$subtotal = 0;
?>

<style>
.cart-wrap {
    padding: 40px;
    max-width: 1100px;
    margin: auto;
}

.cart-title {
    font-size: 2rem;
    margin-bottom: 20px;
}

.cart-item {
    display: flex;
    gap: 18px;
    padding: 18px;
    background: #181818;
    border-radius: 12px;
    margin-bottom: 12px;
}

.cart-thumb {
    width: 140px;
    height: 100px;
    background: #222;
    border-radius: 10px;
    flex-shrink: 0;
}

.cart-thumb img {
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:10px;
}

.cart-meta {
    flex: 1;
}

.cart-meta h4 {
    margin: 0 0 6px;
}

.cart-qty {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 8px;
}

.cart-btn {
    padding: 10px 16px;
    border-radius: 8px;
    background: #00ffa6;
    color: #000;
    border: 0;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
}
.cart-btn:hover {
    background: #00d98c;
}

.cart-btn-remove {
    background: #ff6b6b;
    color: #fff;
}
.cart-btn-remove:hover {
    background: #ff5454;
}

.cart-summary {
    background: #111;
    padding: 18px;
    border-radius: 12px;
    margin-top: 16px;
    text-align: right;
}

#toast {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: #00c977;
    color: #000;
    padding: 14px 24px;
    border-radius: 8px;
    font-weight: 700;
    opacity: 0;
    pointer-events: none;
    transition: 0.3s;
    z-index: 9999;
}
#toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(5px);
}

</style>

<div class="page-content">
<div class="cart-wrap">

<h2 class="cart-title">My Cart</h2>

<div style="margin-bottom:20px;">
    <a href="menu.php" class="cart-btn" style="text-decoration:none;">
        + Add More Items
    </a>
</div>


<?php if ($result->num_rows === 0): ?>
    <p style="color:#bbb;">Your cart is empty.</p>
<?php else: ?>

<?php while ($row = $result->fetch_assoc()):
    $itemTotal = $row["quantity"] * $row["unit_price"];
    $subtotal += $itemTotal;
?>
    <div class="cart-item">
        <div class="cart-thumb">
            <?php if ($row["ImageURL"]): ?>
                <img src="<?= htmlspecialchars($row["ImageURL"]) ?>">
            <?php endif; ?>
        </div>

        <div class="cart-meta">
            <h4>
                <?= htmlspecialchars($row["name"]) ?> —
                RM <?= number_format($row["unit_price"], 2) ?>
            </h4>

            <div class="cart-qty">
                <button
                    class="cart-btn"
                    onclick="decreaseQty(
                        <?= $row['ItemsID'] ?>,
                        <?= $row['quantity'] ?>
                    )"
                >-</button>


                <div class="qty-text"><?= $row["quantity"] ?></div>

                <button
                    class="cart-btn"
                    onclick="increaseQty(
                        <?= $row['ItemsID'] ?>,
                        <?= $row['quantity'] ?>,
                        <?= $row['stock_quantity'] ?>
                    )"
                >+</button>


                <form method="post" action="remove_cart_item.php">
                    <input type="hidden" name="item_id" value="<?= $row['ItemsID'] ?>">
                    <a
                    href="remove_cart_item.php?item_id=<?= $row['ItemsID'] ?>"
                    class="cart-btn cart-btn-remove"
                    style="text-decoration:none;"
                    >
                        Remove
                    </a>

                </form>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<div class="cart-summary">

    <button
        class="cart-btn cart-btn-remove"
        onclick="if(confirm('Clear all items in cart?')) location.href='clear_cart.php';"
        style="margin-right:10px"
    >
        Clear Cart
    </button>

    <button class="cart-btn" onclick="location.href='checkout.php'">
        Proceed to Checkout
    </button>

    <div style="margin-bottom:8px">
        Subtotal: RM <?= number_format($subtotal, 2) ?>
    </div>


</div>

<?php endif; ?>

</div>
</div>

<script>

    function showToast(message) {
        const t = document.getElementById("toast");
        t.textContent = message;
        t.classList.add("show");
        setTimeout(() => t.classList.remove("show"), 3000);
    }

    document.querySelectorAll(".qty-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const itemId = btn.dataset.id;
            const action = btn.dataset.action;

            fetch("update_cart_qty.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `item_id=${itemId}&action=${action}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.deleted) {
                    location.reload();
                } else {
                    location.reload(); 
                }
            });
        });
    });

    function showToast(message) {
        const t = document.getElementById("toast");
        t.textContent = message;
        t.classList.add("show");
        setTimeout(() => t.classList.remove("show"), 3000);
    }

    function decreaseQty(itemId, currentQty) {
        if (currentQty - 1 <= 0) {
            if (confirm("Remove this item from cart?")) {
                window.location.href = "remove_cart_item.php?item_id=" + itemId;
            }
            return;
        }

        window.location.href =
            "update_cart_qty.php?id=" + itemId + "&qty=" + (currentQty - 1);
    }
    
    function increaseQty(itemId, currentQty, stock) {
        if (currentQty + 1 > stock) {
            alert("Cannot exceed available stock");
            return;
        }

        window.location.href =
            "update_cart_qty.php?id=" + itemId + "&qty=" + (currentQty + 1);
    }

</script>
<div id="toast"></div>

<?php
if (isset($_GET["removed"])) {
    $name = htmlspecialchars($_GET["removed"]);
    echo "<script>showToast('{$name} deleted successfully!');</script>";
}

if (isset($_GET["cleared"])) {
    echo "<script>showToast('Cart cleared successfully!');</script>";
}

include 'footer.php'; ?>
