function loadFarmers(){
    $.get("get_farmers.php", function(data){
        let farmers = JSON.parse(data);
        let $farmer = $('#txt_FarmerId');
        $farmer.empty();
        $farmer.append($('<option>').val('').text('Select Farmer'));
        
        farmers.forEach(function(farmer){
            $farmer.append($('<option>').val(farmer.farmer_id).text(farmer.first_name + ' ' + farmer.last_name));
        });
    });
}

function loadCategories(){
    $.get("get_products_inventory.php", function(data){
        let products = JSON.parse(data);
        let categories = [];
        
        products.forEach(function(product){
            if(!categories.includes(product.category)){
                categories.push(product.category);
            }
        });
        
        let $category = $('#txt_Category');
        $category.empty();
        $category.append($('<option>').val('').text('Select category'));
        $category.append($('<option>').val('Vegetables').text('Vegetables'));
        $category.append($('<option>').val('Fruits').text('Fruits'));
        
        categories.forEach(function(cat){
            if(cat !== 'Vegetables' && cat !== 'Fruits'){
                $category.append($('<option>').val(cat).text(cat));
            }
        });
    });
}

function addInventory(){
    const product_id = $("#txt_ProductId").val();
    const farmer_id = $("#txt_FarmerId").val();
    const product_name = $("#txt_ProductName").val();
    const category = $("#txt_Category").val();
    const description = $("#txt_Description").val();
    const unit_price = $("#txt_UnitPrice").val();
    const inventory_id = $("#txt_InventoryId").val();
    const quantity_available = $("#txt_QuantityAvailable").val();
    const date_updated = $("#txt_DateUpdated").val();

    $.post("save.php", {
        product_id: product_id,
        farmer_id: farmer_id,
        product_name: product_name,
        category: category,
        description: description,
        unit_price: unit_price,
        status: "Active"
    },
    function(data){
        let response = JSON.parse(data);
        if(response.msg === "ok"){
            $.post("save.php", {
                inventory_id: inventory_id,
                product_id: product_id,
                quantity_available: quantity_available,
                date_updated: date_updated
            },
            function(inventory_data){
                let inv_response = JSON.parse(inventory_data);
                if(inv_response.msg === "ok"){
                    $("#result").text("Product and Inventory added successfully!");
                    $("#frm_Inventory")[0].reset();
                    loadFarmers();
                    getInventory();
                    
                    setTimeout(function(){
                        $("#result").text("");
                    }, 2000);
                } else {
                    $("#result").text("Error adding inventory");
                }
            });
        } else {
            $("#result").text("Error adding product");
        }
    });
}

function getInventory(){
    $.get("get_inventory_details.php", function(data){
        let inventory = JSON.parse(data);
        let displayData = document.querySelector("#tbl_Inventory");
        let tableContent = "";

        for(let i = 0; i < inventory.length; i++){
            tableContent += `<tr>
                <td>${inventory[i].inventory_id}</td>
                <td>${inventory[i].product_id}</td>
                <td>${inventory[i].product_name}</td>
                <td>${inventory[i].first_name} ${inventory[i].last_name}</td>
                <td>${inventory[i].category}</td>
                <td>₱${parseFloat(inventory[i].unit_price).toFixed(2)}</td>
                <td>${inventory[i].quantity_available}</td>
                <td>${inventory[i].date_updated}</td>
            </tr>`;
        }
        
        if(inventory.length === 0){
            tableContent = '<tr><td colspan="8" style="text-align:center;">No inventory records found</td></tr>';
        }
        
        displayData.innerHTML = tableContent;
    });
}