<?php
include 'header.php';
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];

$custStmt = $conn->prepare("
    SELECT Name, Phone, Address
    FROM customer
    WHERE CustomerID = ?
");
$custStmt->bind_param("s", $customerID);
$custStmt->execute();
$customer = $custStmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("
    SELECT
        ci.ItemsID,
        ci.quantity,
        ci.unit_price,
        p.ProductID,
        p.name,
        p.stock_quantity
    FROM cartitems ci
    JOIN cart c ON c.CartID = ci.CartID
    JOIN product p ON p.ProductID = ci.ProductID
    WHERE c.CustomerID = ?
");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: cart.php");
    exit;
}

$items = [];
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    if ($row["quantity"] > $row["stock_quantity"]) {
        header("Location: cart.php?stock_error=1");
        exit;
    }
    $items[] = $row;
    $subtotal += $row["quantity"] * $row["unit_price"];
}
?>

<style>
.checkout-wrap {
    max-width: 720px;
    margin: auto;
    padding: 40px 30px 60px;
}

.checkout-wrap h2 {
    font-size: 2.2rem;
    margin-bottom: 24px;
    text-align: center;
    letter-spacing: 0.5px;
}

.order-summary,
.checkout-form {
    background: linear-gradient(180deg, #181818, #141414);
    border: 1px solid #222;
    border-radius: 16px;
    padding: 22px;
    margin-bottom: 24px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.45);
}

.order-summary h3 {
    margin: 0 0 14px;
    font-size: 1.2rem;
    color: #00ffa6;
}

.order-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 0.95rem;
    color: #ddd;
}

.order-summary hr {
    border: none;
    border-top: 1px dashed #333;
    margin: 14px 0;
}

.order-summary strong {
    font-size: 1.15rem;
    color: #fff;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 0.9rem;
    color: #aaa;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 14px 14px;
    background: #0f0f0f;
    border: 1px solid #333;
    border-radius: 10px;
    color: #fff;
    font-size: 0.95rem;
    transition: 0.25s;
}

.form-group textarea {
    resize: vertical;
    min-height: 90px;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: #00ffa6;
    box-shadow: 0 0 0 2px rgba(0,255,166,0.15);
}

.payment-group {
    margin-top: 10px;
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    background: #111;
    border: 1px solid #333;
    border-radius: 10px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.25s;
}

.payment-option:hover {
    background: #161616;
}

.payment-option input {
    accent-color: #00ffa6;
    transform: scale(1.15);
}

.card-details {
    display: none;
    margin-top: 20px;
    padding: 20px;
    background: #0f0f0f;
    border: 1px solid #333;
    border-radius: 12px;
}

.card-details.active {
    display: block;
}

.card-row {
    display: flex;
    gap: 15px;
}

.card-row .form-group {
    flex: 1;
}

.form-group.error input,
.form-group.error textarea,
.form-group.error select {
    border-color: #ff4444;
}

.form-group .error-msg {
    color: #ff4444;
    font-size: 0.8rem;
    margin-top: 4px;
    display: none;
}

.form-group.error .error-msg {
    display: block;
}

.form-group.success input,
.form-group.success textarea,
.form-group.success select {
    border-color: #00ffa6;
}

.checkout-btn {
    width: 100%;
    margin-top: 20px;
    padding: 15px 0;
    background: linear-gradient(135deg, #00ffa6, #00d98c);
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.05rem;
    color: #000;
    cursor: pointer;
    transition: 0.25s;
    box-shadow: 0 8px 22px rgba(0,255,166,0.35);
}

.checkout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,255,166,0.5);
}

.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #ff4444;
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.5);
    z-index: 9999;
    max-width: 400px;
    animation: slideIn 0.3s ease-out;
}

.toast.success {
    background: #00ffa6;
    color: #000;
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.toast-close {
    margin-left: 12px;
    cursor: pointer;
    font-weight: bold;
    float: right;
}
</style>

<div class="page-content">
<div class="checkout-wrap">

<h2>Checkout</h2>

<div class="order-summary">
    <h3>Order Summary</h3>
    <?php foreach ($items as $item): ?>
        <div class="order-item">
            <?= htmlspecialchars($item["name"]) ?>
            × <?= $item["quantity"] ?>
            — RM <?= number_format($item["unit_price"], 2) ?>
        </div>
    <?php endforeach; ?>
    <hr>
    <strong>Subtotal: RM <?= number_format($subtotal, 2) ?></strong>
</div>

<form method="post" action="checkout_process.php" class="checkout-form">


    <div class="form-group">
        <label>Full Name *</label>
        <input type="text"
               name="full_name"
               required
               value="<?= htmlspecialchars($customer["Name"] ?? "") ?>">
    </div>

    <div class="form-group">
        <label>Phone *</label>
        <input type="text"
               name="phone"
               required
               pattern="[0-9+\- ]{8,20}"
               value="<?= htmlspecialchars($customer["Phone"] ?? "") ?>">
    </div>

    <div class="form-group">
        <label>Delivery Address *</label>
        <textarea name="address"
                  required
                  minlength="10"><?= htmlspecialchars($customer["Address"] ?? "") ?></textarea>
    </div>

    <div class="form-group">
        <label>Notes (optional)</label>
        <textarea name="notes"></textarea>
    </div>

    <div class="form-group">
    <label>Payment Method *</label>

    <div class="payment-group">
        <label class="payment-option">
            <input type="radio" name="payment_method" value="COD" required>
            Cash on Delivery
        </label>

        <label class="payment-option">
            <input type="radio" name="payment_method" value="Card" required>
            Credit / Debit Card
        </label>
        
        <label class="payment-option">
            <input type="radio" name="payment_method" value="Online Banking" required>
            Online Banking
        </label>
    </div>
</div>

<div class="card-details" id="cardDetails">
    <h4 style="color: #00ffa6; margin-bottom: 20px;">Card Information</h4>
    
    <div class="form-group">
        <label>Cardholder Name *</label>
        <input type="text" 
               name="card_name" 
               id="cardName"
               placeholder="John Doe">
        <span class="error-msg">Please enter the cardholder name</span>
    </div>

    <div class="form-group">
        <label>Card Number *</label>
        <input type="text" 
               name="card_number" 
               id="cardNumber"
               placeholder="1234 5678 9012 3456"
               maxlength="19">
        <span class="error-msg">Please enter a valid 16-digit card number</span>
    </div>

    <div class="card-row">
        <div class="form-group">
            <label>Expiry Date *</label>
            <input type="text" 
                   name="card_expiry" 
                   id="cardExpiry"
                   placeholder="MM/YY"
                   maxlength="5">
            <span class="error-msg">Invalid expiry date (MM/YY)</span>
        </div>

        <div class="form-group">
            <label>CVV *</label>
            <input type="text" 
                   name="card_cvv" 
                   id="cardCVV"
                   placeholder="123"
                   maxlength="4">
            <span class="error-msg">CVV must be 3-4 digits</span>
        </div>
    </div>
</div>

<div class="card-details" id="bankingDetails">
    <h4 style="color: #00ffa6; margin-bottom: 20px;">Online Banking Information</h4>
    
    <div class="form-group">
        <label>Select Bank *</label>
        <select name="bank_name" id="bankName">
            <option value="">-- Choose your bank --</option>
            <option value="Maybank">Maybank</option>
            <option value="CIMB Bank">CIMB Bank</option>
            <option value="Public Bank">Public Bank</option>
            <option value="RHB Bank">RHB Bank</option>
            <option value="Hong Leong Bank">Hong Leong Bank</option>
            <option value="AmBank">AmBank</option>
            <option value="Bank Islam">Bank Islam</option>
            <option value="Affin Bank">Affin Bank</option>
        </select>
        <span class="error-msg">Please select your bank</span>
    </div>

    <div class="form-group">
        <label>Account Holder Name *</label>
        <input type="text" 
               name="account_name" 
               id="accountName"
               placeholder="John Doe">
        <span class="error-msg">Please enter the account holder name</span>
    </div>

    <div class="form-group">
        <label>Account Number *</label>
        <input type="text" 
               name="account_number" 
               id="accountNumber"
               placeholder="1234567890"
               maxlength="20">
        <span class="error-msg">Please enter a valid account number (8-20 digits)</span>
    </div>
</div>

    <button class="checkout-btn">Place Order</button>

</form>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const cardDetails = document.getElementById('cardDetails');
    const bankingDetails = document.getElementById('bankingDetails');
    const form = document.querySelector('.checkout-form');
    
    const cardName = document.getElementById('cardName');
    const cardNumber = document.getElementById('cardNumber');
    const cardExpiry = document.getElementById('cardExpiry');
    const cardCVV = document.getElementById('cardCVV');
    
    const bankName = document.getElementById('bankName');
    const accountName = document.getElementById('accountName');
    const accountNumber = document.getElementById('accountNumber');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Card') {
                cardDetails.classList.add('active');
                bankingDetails.classList.remove('active');
                cardName.required = true;
                cardNumber.required = true;
                cardExpiry.required = true;
                cardCVV.required = true;
                bankName.required = false;
                accountName.required = false;
                accountNumber.required = false;
            } else if (this.value === 'Online Banking') {
                bankingDetails.classList.add('active');
                cardDetails.classList.remove('active');
                bankName.required = true;
                accountName.required = true;
                accountNumber.required = true;
                cardName.required = false;
                cardNumber.required = false;
                cardExpiry.required = false;
                cardCVV.required = false;
            } else {
                cardDetails.classList.remove('active');
                bankingDetails.classList.remove('active');
                cardName.required = false;
                cardNumber.required = false;
                cardExpiry.required = false;
                cardCVV.required = false;
                bankName.required = false;
                accountName.required = false;
                accountNumber.required = false;
            }
        });
    });

    cardNumber.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
        validateCardNumber();
    });

    cardExpiry.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
        validateExpiry();
    });

    cardCVV.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
        validateCVV();
    });

    cardName.addEventListener('blur', function() {
        validateCardName();
    });

    function validateCardName() {
        const value = cardName.value.trim();
        const formGroup = cardName.closest('.form-group');
        
        if (value.length < 3) {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        } else {
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
            return true;
        }
    }

    function validateCardNumber() {
        const value = cardNumber.value.replace(/\s/g, '');
        const formGroup = cardNumber.closest('.form-group');
        
        if (value.length === 16 && /^\d{16}$/.test(value) && luhnCheck(value)) {
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
            return true;
        } else {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        }
    }

    function validateExpiry() {
        const value = cardExpiry.value;
        const formGroup = cardExpiry.closest('.form-group');
        
        if (!/^\d{2}\/\d{2}$/.test(value)) {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        }

        const [month, year] = value.split('/').map(num => parseInt(num));
        const now = new Date();
        const currentYear = now.getFullYear() % 100;
        const currentMonth = now.getMonth() + 1;

        if (month < 1 || month > 12) {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        }

        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        }

        formGroup.classList.remove('error');
        formGroup.classList.add('success');
        return true;
    }

    function validateCVV() {
        const value = cardCVV.value;
        const formGroup = cardCVV.closest('.form-group');
        
        if (value.length >= 3 && value.length <= 4 && /^\d+$/.test(value)) {
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
            return true;
        } else {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        }
    }

    accountNumber.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^\d\s]/g, '');
        validateAccountNumber();
    });

    bankName.addEventListener('change', function() {
        validateBankName();
    });

    accountName.addEventListener('blur', function() {
        validateAccountName();
    });

    function validateBankName() {
        const value = bankName.value;
        const formGroup = bankName.closest('.form-group');
        
        if (value === '') {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        } else {
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
            return true;
        }
    }

    function validateAccountName() {
        const value = accountName.value.trim();
        const formGroup = accountName.closest('.form-group');
        
        if (value.length < 3) {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        } else {
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
            return true;
        }
    }

    function validateAccountNumber() {
        const value = accountNumber.value.replace(/\s/g, '');
        const formGroup = accountNumber.closest('.form-group');
        
        if (value.length >= 8 && value.length <= 20 && /^\d+$/.test(value)) {
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
            return true;
        } else {
            formGroup.classList.add('error');
            formGroup.classList.remove('success');
            return false;
        }
    }

    form.addEventListener('submit', function(e) {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        
        if (selectedPayment && selectedPayment.value === 'Card') {
            let isValid = true;
            
            if (!validateCardName()) isValid = false;
            if (!validateCardNumber()) isValid = false;
            if (!validateExpiry()) isValid = false;
            if (!validateCVV()) isValid = false;
            
            if (!isValid) {
                e.preventDefault();
                showToast('Please fix the card information errors before proceeding.');
                return false;
            }
        } else if (selectedPayment && selectedPayment.value === 'Online Banking') {
            let isValid = true;
            
            if (!validateBankName()) isValid = false;
            if (!validateAccountName()) isValid = false;
            if (!validateAccountNumber()) isValid = false;
            
            if (!isValid) {
                e.preventDefault();
                showToast('Please fix the banking information errors before proceeding.');
                return false;
            }
        }
    });
});

function showToast(message, type = 'error') {
    const toast = document.createElement('div');
    toast.className = 'toast' + (type === 'success' ? ' success' : '');
    toast.innerHTML = `
        ${message}
        <span class="toast-close" onclick="this.parentElement.remove()">×</span>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

const urlParams = new URLSearchParams(window.location.search);
const errorMsg = urlParams.get('error');
if (errorMsg) {
    showToast(errorMsg);
    window.history.replaceState({}, document.title, window.location.pathname);
}

function luhnCheck(cardNumber) {
    let sum = 0;
    let isEven = false;
    
    for (let i = cardNumber.length - 1; i >= 0; i--) {
        let digit = parseInt(cardNumber.charAt(i));
        
        if (isEven) {
            digit *= 2;
            if (digit > 9) {
                digit -= 9;
            }
        }
        
        sum += digit;
        isEven = !isEven;
    }
    
    return (sum % 10) === 0;
}
</script>

<?php include 'footer.php'; ?>
