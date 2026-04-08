<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Farmer</h1>
    <div style="margin-bottom: 15px;">
      <button onclick="location.href='index.php'">Back</button>
      <button onclick="location.href='farmer_form.php'" style="margin-left: 10px;">Add Farmer</button>
      <button onclick="location.href='product.php'" style="margin-left: 10px;">Product</button>
      <button onclick="location.href='inventory.php'" style="margin-left: 10px;">Inventory</button>
      <button onclick="location.href='order.php'" style="margin-left: 10px;">Order</button>
    </div>
    <section class="choose-farmer">
      <div class="choose-text">
        <h2>Choose a Farmer</h2>
        <p class="subtext">Select a farmer to proceed with buying a product.</p>
      </div>
    </section>

    <table border="1" style="width:100%; border-collapse:collapse; margin-top: 20px;">
      <thead>
        <tr>
          <th>Farmer ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Contact Number</th>
          <th>Email</th>
          <th>Address</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbl_Farmer">
        <tr>
          <td colspan="8" style="text-align:center;">Loading farmers...</td>
        </tr>
      </tbody>
    </table>
  <script src="jquery.js"></script>
  <script src="farmer_select.js"></script>
  <script>
    $(document).ready(function(){
      getFarmers();
    });
  </script>
</body>
</html>