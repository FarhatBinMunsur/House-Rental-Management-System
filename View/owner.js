document.addEventListener("DOMContentLoaded", function () {

    const propertyForm =
        document.getElementById("propertyForm");

    if (propertyForm) {

        propertyForm.addEventListener("submit",async function (event) {

                event.preventDefault();

                const title = document.getElementById("title");

                const propertyType = document.getElementById("propertyType");

                const location = document.getElementById("location");

                const rent = document.getElementById("rent");

                const bedrooms = document.getElementById("bedrooms");

                const bathrooms = document.getElementById("bathrooms");

                const area = document.getElementById("area");

                const availabilityDate = document.getElementById("availabilityDate");

                const description = document.getElementById("description");

                const images = document.getElementById("images");

                const titleError = document.getElementById("titleError");

                const propertyTypeError = document.getElementById("propertyTypeError");

                const locationError = document.getElementById("locationError");

                const rentError = document.getElementById("rentError");

                const bedroomsError = document.getElementById("bedroomsError");

                const bathroomsError = document.getElementById( "bathroomsError");

                const areaError = document.getElementById("areaError");

                const availabilityDateError = document.getElementById("availabilityDateError");

                const descriptionError = document.getElementById("descriptionError");

                const imagesError = document.getElementById("imagesError");

                const message = document.getElementById("propertyMessage");

                titleError.textContent = "";

                propertyTypeError.textContent = "";

                locationError.textContent = "";

                rentError.textContent = "";

                bedroomsError.textContent = "";

                bathroomsError.textContent = "";

                areaError.textContent = "";

                availabilityDateError.textContent = "";

                descriptionError.textContent = "";

                imagesError.textContent = "";

                message.textContent = "";


                let valid = true;

// javascript validation satrt form here.......

                if (title.value.trim() === "") {

                    titleError.textContent = "Property title is required ";

                    valid = false;

                } 
                else if (title.value.trim().length > 200) {

                    titleError.textContent = "Maximum 200 characters.";

                    valid = false;
                }


                if (
                    propertyType.value === ""
                ) {

                    propertyTypeError.textContent =
                        "Select a property type.";

                    valid = false;
                }

                if ( location.value.trim() === "") {

                    locationError.textContent ="Location is required.";

                    valid = false;

                } 
                else if (location.value.trim().length > 255) {

                    locationError.textContent ="Maximum 255 characters.";

                    valid = false;
                }

                if (rent.value === "" || Number(rent.value) <= 0) {

                    rentError.textContent = "Enter a valid monthly rent.";

                    valid = false;
                }

                if ( bedrooms.value === "" || Number(bedrooms.value) < 0 || 
                     !Number.isInteger(Number(bedrooms.value)))
                 {

                    bedroomsError.textContent = "Enter a valid bedroom number.";

                    valid = false;
                }


                if ( bathrooms.value === "" || Number(bathrooms.value) < 0 ||
                    !Number.isInteger(Number(bathrooms.value))) 
                    {

                    bathroomsError.textContent ="Enter a valid bathroom number.";
                    valid = false;
                }

                if ( area.value === "" || Number(area.value) <= 0 ||
                    !Number.isInteger( Number(area.value))) {

                    areaError.textContent = "Enter a valid area.";
                    valid = false;
                }


                if (availabilityDate.value === "") {

                    availabilityDateError.textContent ="Availability date is required.";
                    valid = false;
                }

                if (description.value.length > 1000) {

                    descriptionError.textContent ="Maximum 1000 characters.";
                    valid = false;
                }

                const allowedExtensions = ["jpg","jpeg","png"];

                for (let i = 0; i < images.files.length;i++) {

                    const file = images.files[i];

                    const extension = file.name.split(".").pop().toLowerCase();


                    if (!allowedExtensions.includes(extension)) {
                        
                        imagesError.textContent ="Only PNG, JPG and JPEG images are allowed.";
                        valid = false;
                        break;
                    }


                    if (file.size > 10 * 1024 * 1024) {

                        imagesError.textContent ="Each image must be 10MB or smaller.";
                        valid = false;
                        break;
                    }
                }

                if (!valid) 
                {
                    return;
                }

// send validated property form and uploaded files to PropertyController.php

                try {
                    const response =
                        await fetch("../Controller/PropertyController.php?action=create",
                            {
                                method: "POST",
                                body:new FormData(propertyForm)
                            }
                        );

                    const responseText = await response.text();

                    console.log("PropertyController response:",responseText);

                    let data;

                    try {

                        data =JSON.parse(responseText);

                    } catch (jsonError) {

                        console.error("Invalid JSON returned by PHP:", jsonError);

                        message.className ="error-message";

                        message.textContent ="Server returned an invalid response. Check the browser console.";

                        return;
                    }

                    message.className = data.success ? "success-message" : "error-message";

                    message.textContent = data.message;

                    if (data.success) {
                        propertyForm.reset();
                    }


                } catch (error) {

                    console.error("Property request error:",error);

                    message.className ="error-message";

                    message.textContent ="Server error. Please try again.";
                }
            }
        );
    }
});


async function loadDashboardStats()
{
    try {

        const response = await fetch(
            "Controller/PropertyController.php?action=stats"
        );

        const responseText = await response.text();

        console.log(
            "PropertyController response:", responseText);

        const data = JSON.parse(responseText);

        if (data.success) {

            document.getElementById("totalPosts").textContent = data.data.totalPosts + " Posts";


            document.getElementById("availableRents").textContent = data.data.availableRents + " Rents";

            document.getElementById("rentOngoing").textContent = data.data.rentOngoing + " Rents";
        }

    } catch (error) {

        console.error( "Could not load dashboard statistics:",error);

    }
}

async function updateBookingStatus(bookingID,status)
{
    const formData = new FormData();

    formData.append("bookingID",bookingID);

    formData.append("status",status);


    const message =document.getElementById("bookingMessage");

    try {

        const response = await fetch(
                "../Controller/BookingController.php?action=updateStatus",
                {
                    method: "POST",
                    body: formData
                }
            );

        const responseText = await response.text();

        console.log( "BookingController response:",responseText);

        let data;
        try {

            data = JSON.parse(responseText);

        } catch (jsonError) {

            console.error(
                "Invalid JSON from BookingController:",
                jsonError
            );

            message.className = "error-message";

            message.textContent = "Server returned an invalid response.";

            return;
        }


        if (!data.success) {

            message.className = "error-message";

            message.textContent = data.message;

            return;
        }
        message.className = "success-message";

        message.textContent = data.message;

        const row = document.getElementById("booking-" + bookingID);

        if (row) {

            const actionCell = row.querySelector(".booking-action-cell");

            if (actionCell) {

                if (status === "ACCEPTED") {

                    actionCell.innerHTML =
                        '<span class="status-badge status-accepted">Accepted</span>';

                } else {

                    actionCell.innerHTML =
                        '<span class="status-badge status-rejected">Rejected</span>';
                }
            }
        }


    } catch (error) {

        console.error("Booking request error:",error);

        message.className = "error-message";

        message.textContent ="Server error. Please try again.";
    }
}