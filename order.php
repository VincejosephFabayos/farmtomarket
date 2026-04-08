<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Checkout & Orders</h1>
    <div style="margin-bottom: 15px;">
      <button onclick="location.href='product.php'">Select Products</button>
      <button onclick="location.href='index.php'">Back</button>
    </div>

    <h2>Shopping Cart</h2>
    <table border="1" style="width:100%; border-collapse:collapse; margin-bottom: 20px;">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Unit Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbl_Cart">
        <tr><td colspan="5" style="text-align:center;">No items in cart</td></tr>
      </tbody>
    </table>

    <div style="margin-bottom: 20px; text-align: right; font-weight: bold;">
      Total Amount: ₱<span id="total_amount">0.00</span>
    </div>

    <h2>Customer Information</h2>
    <form id="frm_Order" style="background: #ffffff;">
      <label for="txt_CustomerId">Customer ID</label>
      <input name="customer_id" id="txt_CustomerId" type="text" placeholder="" required>

      <label for="txt_OrderStatus">Order Status</label>
      <input name="order_status" id="txt_OrderStatus" type="text" value="Pending" readonly>

      <label for="txt_PaymentStatus">Payment Status</label>
      <input name="payment_status" id="txt_PaymentStatus" type="text" value="Unpaid" readonly>

      <button type="button" onclick="placeOrder()">Place Order</button>
    </form>

    <div id="result" style="margin-top: 15px; padding: 10px; background: #f0f0f0; display: none;"></div>

    <div id="order_details_section" style="display: none; background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
      <table border="1" style="width:100%; border-collapse:collapse;">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody id="tbl_OrderDetails">
        </tbody>
      </table>
      <div style="margin-top: 15px; text-align: right; font-weight: bold;">
        Order Total: ₱<span id="order_total">0.00</span>
      </div>
      <div style="margin-top: 10px; padding: 10px; background: #e8f5e9; border-radius: 3px; color: #2e7d32;">
        <strong>✓ Order placed successfully!</strong> Order ID: <span id="placed_order_id"></span>
      </div>
    </div>
  </div>

  <script src="jquery.js"></script>
  <script>
    $(document).ready(function() {
      displayCart();
    });

    function removeFromCart(productId) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart = cart.filter(c => c.product_id != productId);
      localStorage.setItem('cart', JSON.stringify(cart));
      displayCart();
    }

    function displayCart() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      let tableContent = '';
      let total = 0;

      if(cart.length > 0) {
        cart.forEach(item => {
          let itemSubtotal = item.unit_price * item.quantity;
          total += itemSubtotal;
          tableContent += `<tr>
            <td>${item.product_name}</td>
            <td>₱${parseFloat(item.unit_price).toFixed(2)}</td>
            <td>${item.quantity}</td>
            <td>₱${itemSubtotal.toFixed(2)}</td>
            <td><button type="button" onclick="removeFromCart(${item.product_id})">Remove</button></td>
          </tr>`;
        });
      } else {
        tableContent = '<tr><td colspan="5" style="text-align:center;">No items in cart</td></tr>';
      }

      $('#tbl_Cart').html(tableContent);
      $('#total_amount').text(total.toFixed(2));
    }

    function placeOrder() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      if(cart.length === 0) { alert('Your cart is empty!'); return; }

      let customer_id = $('#txt_CustomerId').val();
      if(!customer_id) { alert('Please enter Customer ID'); return; }

      let order_id = 'ORD-' + Date.now();
      let order_date = new Date().toISOString().split('T')[0];
      let total_amount = $('#total_amount').text();
      let order_status = $('#txt_OrderStatus').val();
      let payment_status = $('#txt_PaymentStatus').val();

      $.post('save.php', {
        order_id: order_id,
        customer_id: customer_id,
        order_date: order_date,
        total_amount: total_amount,
        order_status: order_status,
        payment_status: payment_status
      }, function(res) {
        let response = JSON.parse(res);
        if(response.msg === 'ok') {
          let detailsSaved = 0;
          cart.forEach((item, index) => {
            $.post('save.php', {
              orderdetails_id: order_id + '-' + (index + 1),
              order_id: order_id,
              product_id: item.product_id,
              quantity: item.quantity,
              subtotal: item.unit_price * item.quantity
            }, function() {
              detailsSaved++;
              if(detailsSaved === cart.length) {
                showOrderDetails(cart, order_id, total_amount);
                localStorage.removeItem('cart');
                $('#frm_Order')[0].reset();
                displayCart();
              }
            });
          });
        } else {
          alert('Error placing order');
        }
      });
    }

    function showOrderDetails(cart, orderId, total) {
      let tableContent = '';
      cart.forEach(item => {
        tableContent += `<tr>
          <td>${item.product_name}</td>
          <td>${item.quantity}</td>
          <td>₱${parseFloat(item.unit_price).toFixed(2)}</td>
          <td>₱${(item.unit_price * item.quantity).toFixed(2)}</td>
        </tr>`;
      });
      $('#tbl_OrderDetails').html(tableContent);
      $('#order_total').text(parseFloat(total).toFixed(2));
      $('#placed_order_id').text(orderId);
      $('#order_details_section').show();
      $('html, body').animate({ scrollTop: $('#order_details_section').offset().top }, 500);
    }
  </script>
</body>
</html>