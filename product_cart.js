function getProducts(){
    $.get("get_products_inventory.php", function(data){
        let products = JSON.parse(data);
        let selectedFarmerId = localStorage.getItem('selectedFarmerId');
        

        if(selectedFarmerId){
            products = products.filter(p => p.farmer_id == selectedFarmerId);
        }

        let categories = [];
        let categoryMap = {};
        

        products.forEach(function(product){
            if(!categories.includes(product.category)){
                categories.push(product.category);
            }
            if(!categoryMap[product.category]){
                categoryMap[product.category] = [];
            }
            categoryMap[product.category].push(product);
        });
        

        let $category = $('#txt_Category');
        categories.forEach(function(cat){
            $category.append($('<option>').val(cat).text(cat));
        });
        

        let farmerName = localStorage.getItem('selectedFarmerName');
        if(farmerName){
            $('#selectedFarmerInfo').html('<strong>Selected Farmer:</strong> ' + farmerName).show();
        }
        

        window.allProducts = products;
        window.categoryMap = categoryMap;
    });
}

$(document).on('change', '#txt_Category', function(){
    let category = $(this).val();
    let $product = $('#txt_ProductId');
    $product.empty();
    $product.append($('<option>').val('').text('Select item'));
    
    if(category && window.categoryMap[category]){
        window.categoryMap[category].forEach(function(product){
            let optionText = product.product_name + ' - ₱' + parseFloat(product.unit_price).toFixed(2);
            $product.append($('<option>').val(product.product_id).text(optionText).data('product', product));
        });
    }
    
    $('#txt_UnitPrice').val('');
    $('#txt_QuantityAvailable').val('');
    $('#txt_Subtotal').val('');
});

$(document).on('change', '#txt_ProductId', function(){
    let productId = $(this).val();
    $('#txt_Subtotal').val('');
    
    if(productId && window.allProducts){
        let product = window.allProducts.find(p => p.product_id == productId);
        if(product){
            $('#txt_UnitPrice').val('₱' + parseFloat(product.unit_price).toFixed(2));
            $('#txt_QuantityAvailable').val(product.quantity_available + ' units');
            $('#txt_Quantity').attr('max', product.quantity_available);
            calculateSubtotal();
        }
    }
});

$(document).on('change', '#txt_Quantity', function(){
    calculateSubtotal();
});

function calculateSubtotal(){
    let unitPrice = $('#txt_UnitPrice').val();
    let quantity = parseInt($('#txt_Quantity').val()) || 0;
    
    if(unitPrice && quantity > 0){
        let price = parseFloat(unitPrice.replace('₱', ''));
        let subtotal = price * quantity;
        $('#txt_Subtotal').val('₱' + subtotal.toFixed(2));
    } else {
        $('#txt_Subtotal').val('');
    }
}

function addToCart(){
    const product_id = $("#txt_ProductId").val();
    let fullText = $("#txt_ProductId option:selected").text();
    const product_name = fullText.split(' - ')[0];
    const category = $("#txt_Category").val();
    const unit_price = parseFloat($("#txt_UnitPrice").val().replace('₱', ''));
    const quantity = parseInt($("#txt_Quantity").val());
    
    if(!product_id || !category){
        $("#result").text("Please select product and category");
        return;
    }
    
    if(quantity > parseInt($("#txt_QuantityAvailable").val())){
        $("#result").text("Quantity exceeds available stock!");
        return;
    }
    

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    

    let existingItem = cart.find(item => item.product_id == product_id);
    
    if(existingItem){
        existingItem.quantity += quantity;
    } else {
        cart.push({
            product_id: product_id,
            product_name: product_name,
            category: category,
            unit_price: unit_price,
            quantity: quantity,
            subtotal: unit_price * quantity
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    $("#result").text("Item added to cart!");
    $('#frm_Product')[0].reset();
    $('#txt_UnitPrice').val('');
    $('#txt_QuantityAvailable').val('');
    $('#txt_Subtotal').val('');
    $("#txt_ProductId").empty().append($('<option>').val('').text('Select item'));
    
    setTimeout(function(){
        $("#result").text("");
    }, 2000);
    
    displayCart();
}

function displayCart(){
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let displayData = document.querySelector("#tbl_Cart");
    let tableContent = "";
    let totalAmount = 0;
    
    if(cart.length === 0){
        displayData.innerHTML = '<tr><td colspan="6" style="text-align:center;">Your cart is empty</td></tr>';
        $("#totalAmount").text("0.00");
        $("#checkoutBtn").prop('disabled', true);
        $("#clearCartBtn").prop('disabled', true);
        return;
    }
    
    cart.forEach(function(item, index){
        let subtotal = item.unit_price * item.quantity;
        totalAmount += subtotal;
        
        tableContent += `<tr>
            <td>${item.product_name}</td>
            <td>${item.category}</td>
            <td>₱${parseFloat(item.unit_price).toFixed(2)}</td>
            <td><input type="number" min="1" value="${item.quantity}" data-index="${index}" class="qty-input" style="width:60px;"></td>
            <td>₱${subtotal.toFixed(2)}</td>
            <td><button class="remove-btn" data-index="${index}">Remove</button></td>
        </tr>`;
    });
    
    displayData.innerHTML = tableContent;
    $("#totalAmount").text(totalAmount.toFixed(2));
    $("#checkoutBtn").prop('disabled', false);
    $("#clearCartBtn").prop('disabled', false);
    

    $('.qty-input').on('change', function(){
        let index = $(this).data('index');
        let qty = parseInt($(this).val());
        
        if(qty > 0){
            cart[index].quantity = qty;
            cart[index].subtotal = cart[index].unit_price * qty;
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }
    });
    

    $('.remove-btn').on('click', function(){
        let index = $(this).data('index');
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCart();
    });
}
