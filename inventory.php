<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Inventory</h1>
    <div style="margin-bottom: 15px;">
      <button onclick="location.href='farmer.php'">Back</button>
      <button onclick="location.href='farmer_form.php'" style="margin-left: 10px;">Add Farmer</button>
      <button onclick="location.href='product.php'" style="margin-left: 10px;">Product</button>
      <button onclick="location.href='inventory.php'" style="margin-left: 10px;">Inventory</button>
      <button onclick="location.href='order.php'" style="margin-left: 10px;">Order</button>
    </div>

    <form id="frm_Inventory">
      <h3>Add Product with Inventory</h3>
      
      <label for="txt_FarmerId">Farmer</label>
      <select name="farmer_id" id="txt_FarmerId" required>
        <option value="">Select Farmer</option>
      </select>

      <label for="txt_ProductId">Product ID</label>
      <input name="product_id" id="txt_ProductId" type="text" required>

      <label for="txt_ProductName">Product Name</label>
      <input name="product_name" id="txt_ProductName" type="text" required>

      <label for="txt_Category">Category</label>
      <select name="category" id="txt_Category" required>
        <option value="">Select category</option>
      </select>

      <label for="txt_Description">Description</label>
      <input name="description" id="txt_Description" type="text" required>

      <label for="txt_UnitPrice">Unit Price</label>
      <input name="unit_price" id="txt_UnitPrice" type="number" step="0.01" required>

      <label for="txt_InventoryId">Inventory ID</label>
      <input name="inventory_id" id="txt_InventoryId" type="text" required>

      <label for="txt_QuantityAvailable">Quantity Available</label>
      <input name="quantity_available" id="txt_QuantityAvailable" type="number" required>

      <label for="txt_DateUpdated">Date Updated</label>
      <input name="date_updated" id="txt_DateUpdated" type="date" required>

      <input type="submit" value="Add Product & Inventory">
    </form>

    <div id="result" style="margin-top: 15px;"></div>

    <section class="choose-farmer">
      <div class="choose-text">
        <h2>Inventory Management</h2>
        <p class="subtext">View and manage inventory records.</p>
      </div>
    </section>

    <table border="1" style="width:100%; border-collapse:collapse; margin-top: 20px;">
      <thead>
        <tr>
          <th>Inventory ID</th>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Farmer</th>
          <th>Category</th>
          <th>Unit Price</th>
          <th>Quantity Available</th>
          <th>Date Updated</th>
        </tr>
      </thead>
      <tbody id="tbl_Inventory">
        <tr>
          <td colspan="8" style="text-align:center;">Loading inventory...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <script src="jquery.js"></script>
  <script src="inventory.js"></script>
  <script>
    $(document).ready(function(){
      loadFarmers();
      loadCategories();
      getInventory();
    });

    $('#frm_Inventory').on('submit', function(e){
      e.preventDefault();
      addInventory();
    });
  </script>
</body>
</html>