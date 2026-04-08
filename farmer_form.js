function addFarmer(){
    const farmer_id = $("#txt_FarmerId").val();
    const first_name = $("#txt_FirstName").val();
    const last_name = $("#txt_LastName").val();
    const contact_number = $("#txt_ContactNumber").val();
    const email = $("#txt_Email").val();
    const address = $("#txt_Address").val();
    const registration_date = $("#txt_RegistrationDate").val();
    const status = $("#txt_Status").val();

    $.post("save.php", {
        farmer_id: farmer_id,
        first_name: first_name,
        last_name: last_name,
        contact_number: contact_number,
        email: email,
        address: address,
        registration_date: registration_date,
        status: status
    },
    function(data){
        let response = JSON.parse(data);
        if(response.msg === "ok"){
            $("#result").text("Farmer added successfully!");
            $("#result").css("color", "green");
            $("#frm_Farmer")[0].reset();
            getFarmers();
            
            setTimeout(function(){
                $("#result").text("");
            }, 2000);
        } else {
            let errorMsg = "Error adding farmer";
            if(response.error) {
                errorMsg = "Error: " + response.error;
            }
            $("#result").text(errorMsg);
            $("#result").css("color", "red");
        }
    }).fail(function(xhr, status, error) {
        $("#result").text("Failed to connect to server: " + error);
        $("#result").css("color", "red");
        console.log("XHR Response:", xhr.responseText);
    });
}

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
                <td>${farmers[i].registration_date}</td>
                <td>${farmers[i].status}</td>
            </tr>`;
        }
        
        if(farmers.length === 0){
            tableContent = '<tr><td colspan="8" style="text-align:center;">No farmers found</td></tr>';
        }
        
        displayData.innerHTML = tableContent;
    });
}
