<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Farmer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Add Farmer</h1>
    <button onclick="location.href='farmer.php'" style="margin-bottom: 20px;">Back</button>

    <form id="frm_Farmer">
      <label for="txt_FarmerId">Farmer ID</label>
      <input type="text" id="txt_FarmerId" name="farmer_id" required>

      <label for="txt_FirstName">First Name</label>
      <input type="text" id="txt_FirstName" name="first_name" required>

      <label for="txt_LastName">Last Name</label>
      <input type="text" id="txt_LastName" name="last_name" required>

      <label for="txt_ContactNumber">Contact Number</label>
      <input type="text" id="txt_ContactNumber" name="contact_number" required>

      <label for="txt_Email">Email</label>
      <input type="email" id="txt_Email" name="email" required>

      <label for="txt_Address">Address</label>
      <input type="text" id="txt_Address" name="address" required>

      <label for="txt_RegistrationDate">Registration Date</label>
      <input type="date" id="txt_RegistrationDate" name="registration_date" required>

      <label for="txt_Status">Status</label>
      <select id="txt_Status" name="status" required>
        <option value="">Select Status</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <input type="submit" value="Add Farmer">
    </form>

    <div id="result"></div>

    <h2>Farmers List</h2>
    <table border="1" style="width:100%; border-collapse:collapse; margin-top: 20px;">
      <thead>
        <tr>
          <th>Farmer ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Contact Number</th>
          <th>Email</th>
          <th>Address</th>
          <th>Registration Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="tbl_Farmer">
        <tr>
          <td colspan="8" style="text-align:center;">Loading farmers...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <script src="jquery.js"></script>
  <script src="farmer_form.js"></script>
  <script>
    $(document).ready(function(){
      getFarmers();
    });

    $('#frm_Farmer').on('submit', function(e){
      e.preventDefault();
      addFarmer();
    });
  </script>
</body>
</html>
