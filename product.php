<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Product</h1>
    <div style="margin-bottom: 15px;">
      <button onclick="location.href='index.php'">Back</button>
      <button onclick="location.href='farmer_form.php'" style="margin-left: 10px;">Add Farmer</button>
      <button onclick="location.href='product.php'" style="margin-left: 10px;">Product</button>
      <button onclick="location.href='inventory.php'" style="margin-left: 10px;">Inventory</button>
      <button onclick="location.href='order.php'" style="margin-left: 10px;">Order</button>
    </div>

    <div id="selectedFarmerInfo" style="background-color: #e8f5e9; padding: 10px; margin-bottom: 20px; border-radius: 5px; display: none;"></div>

    <form id="frm_Product">
      <label for="txt_Category">Category</label>
      <select name="category" id="txt_Category">
        <option value="">Select category</option>
      </select>

      <label for="txt_ProductId">Item</label>
      <select name="product_id" id="txt_ProductId">
        <option value="">Select item</option>
      </select>

      <label for="txt_UnitPrice">Unit Price</label>
      <input type="text" id="txt_UnitPrice" readonly>

      <label for="txt_QuantityAvailable">Available Stock</label>
      <input type="text" id="txt_QuantityAvailable" readonly style="background-color: #f9f9f9;">

      <label for="txt_Quantity">Quantity</label>
      <input type="number" name="quantity" id="txt_Quantity" min="1" value="1">

      <label for="txt_Subtotal">Subtotal</label>
      <input type="text" id="txt_Subtotal" readonly style="background-color: #fff3cd; font-weight: bold;">

      <input type="submit" value="Add to Cart">
    </form>

    <div id="result"></div>

    <h2>Shopping Cart</h2>
    <table border="1" style="width:100%; border-collapse:collapse;">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Category</th>
          <th>Unit Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbl_Cart">
        <tr>
          <td colspan="6" style="text-align:center;">Your cart is empty</td>
        </tr>
      </tbody>
    </table>

    <div style="margin-top: 20px;">
      <h3>Total Amount: <span id="totalAmount">0.00</span></h3>
      <button id="checkoutBtn" onclick="location.href='order.php'" type="button" disabled>Proceed to Checkout</button>
      <button id="clearCartBtn" type="button" disabled>Clear Cart</button>
    </div>
  </div>

  <script src="jquery.js"></script>
  <script src="product_cart.js"></script>
  <script>
    $(document).ready(function(){
      getProducts();
      displayCart();
    });

    $('#frm_Product').on('submit', function(e){
      e.preventDefault();
      addToCart();
    });

    $('#clearCartBtn').on('click', function(){
      if(confirm('Clear cart?')){
        localStorage.removeItem('cart');
        displayCart();
      }
    });
  </script>
</body>
</html>