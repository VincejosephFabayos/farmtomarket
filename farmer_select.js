function getFarmers(){
    $.get("get_farmers.php", function(data){
        let farmers = JSON.parse(data);
        let displayData = document.querySelector("#tbl_Farmer");
        let tableContent = "";

        for(let i = 0; i < farmers.length; i++){
            tableContent += `<tr>
                <td>${farmers[i].farmer_id}</td>
                <td>${farmers[i].first_name}</td>
                <td>${farmers[i].last_name}</td>
                <td>${farmers[i].contact_number}</td>
                <td>${farmers[i].email}</td>
                <td>${farmers[i].address}</td>
                <td>${farmers[i].status}</td>
                <td>
                    <button class="select-farmer-btn" data-farmer-id="${farmers[i].farmer_id}" data-farmer-name="${farmers[i].first_name} ${farmers[i].last_name}">Select</button>
                </td>
            </tr>`;
        }
        
        if(farmers.length === 0){
            tableContent = '<tr><td colspan="8" style="text-align:center;">No farmers found</td></tr>';
        }
        
        displayData.innerHTML = tableContent;

        $('.select-farmer-btn').on('click', function(){
            selectFarmer($(this).data('farmer-id'), $(this).data('farmer-name'));
        });
    });
}

function selectFarmer(farmerId, farmerName){
    localStorage.setItem('selectedFarmerId', farmerId);
    localStorage.setItem('selectedFarmerName', farmerName);
    
    alert('Selected Farmer: ' + farmerName);
    
    document.getElementById('proceedDiv').style.display = 'block';
}
