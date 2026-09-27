<?php

session_start();

require_once "../db/db.php";
require_once "../Model/Property.php";

header("Content-Type: application/json");


// ======================================================
// CHECK OWNER LOGIN
// ======================================================

if (
    !isset($_SESSION["userId"]) ||
    strtoupper($_SESSION["userRole"] ?? "") !== "OWNER"
) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Please sign in as an owner."
    ]);

    exit();
}


// ======================================================
// CREATE PROPERTY MODEL
// ======================================================

$propertyModel = new Property();

$action = $_GET["action"] ?? "";


// ======================================================
// CREATE NEW PROPERTY
// ======================================================

if ($action === "create") {

    // Only POST request is allowed
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {

        echo json_encode([
            "success" => false,
            "message" => "Invalid request."
        ]);

        exit();
    }


    // ==================================================
    // GET FORM DATA
    // ==================================================

    $title = trim(
        $_POST["title"] ?? ""
    );

    $propertyType = trim(
        $_POST["propertyType"] ?? ""
    );

    $location = trim(
        $_POST["location"] ?? ""
    );

    $rent = trim(
        $_POST["rent"] ?? ""
    );

    $bedrooms = trim(
        $_POST["bedrooms"] ?? ""
    );

    $bathrooms = trim(
        $_POST["bathrooms"] ?? ""
    );

    $area = trim(
        $_POST["area"] ?? ""
    );

    $availabilityDate = trim(
        $_POST["availabilityDate"] ?? ""
    );

    $description = trim(
        $_POST["description"] ?? ""
    );

    // New property is available by default
    $status = "pending";

    $errors = [];


    // ==================================================
    // VALIDATE PROPERTY TITLE
    // ==================================================

    if ($title === "") {

        $errors[] =
            "Property title is required.";

    } elseif (strlen($title) > 200) {

        $errors[] =
            "Property title is too long.";
    }


    // ==================================================
    // VALIDATE PROPERTY TYPE
    // ==================================================

    $allowedTypes = [
        "Villa",
        "Apartment",
        "House",
        "Townhouse",
        "Cabin",
        "Studio"
    ];

    if ($propertyType === "") {

        $errors[] =
            "Property type is required.";

    } elseif (
        !in_array(
            $propertyType,
            $allowedTypes,
            true
        )
    ) {

        $errors[] =
            "Invalid property type.";
    }


    // ==================================================
    // VALIDATE LOCATION
    // ==================================================

    if ($location === "") {

        $errors[] =
            "Location is required.";

    } elseif (strlen($location) > 255) {

        $errors[] =
            "Location is too long.";
    }


    // ==================================================
    // VALIDATE RENT
    // ==================================================

    if ($rent === "") {

        $errors[] =
            "Monthly rent is required.";

    } elseif (
        !is_numeric($rent) ||
        (float)$rent <= 0
    ) {

        $errors[] =
            "Monthly rent must be greater than 0.";
    }


    // ==================================================
    // VALIDATE BEDROOMS
    // ==================================================

    if (
        $bedrooms === "" ||
        filter_var(
            $bedrooms,
            FILTER_VALIDATE_INT
        ) === false ||
        (int)$bedrooms < 0
    ) {

        $errors[] =
            "Bedrooms must be 0 or more.";
    }


    // ==================================================
    // VALIDATE BATHROOMS
    // ==================================================

    if (
        $bathrooms === "" ||
        filter_var(
            $bathrooms,
            FILTER_VALIDATE_INT
        ) === false ||
        (int)$bathrooms < 0
    ) {

        $errors[] =
            "Bathrooms must be 0 or more.";
    }


    // ==================================================
    // VALIDATE AREA
    // ==================================================

    if (
        $area === "" ||
        filter_var(
            $area,
            FILTER_VALIDATE_INT
        ) === false ||
        (int)$area <= 0
    ) {

        $errors[] =
            "Area must be greater than 0.";
    }


    // ==================================================
    // VALIDATE AVAILABILITY DATE
    // ==================================================

    if ($availabilityDate === "") {

        $errors[] =
            "Availability date is required.";

    } else {

        $date = DateTime::createFromFormat(
            "Y-m-d",
            $availabilityDate
        );

        if (
            !$date ||
            $date->format("Y-m-d") !==
            $availabilityDate
        ) {

            $errors[] =
                "Invalid availability date.";
        }
    }


    // ==================================================
    // VALIDATE DESCRIPTION
    // ==================================================

    if (strlen($description) > 1000) {

        $errors[] =
            "Description cannot exceed 1000 characters.";
    }


    // ==================================================
    // IMAGE VALIDATION
    // ==================================================

    $savedImages = [];

    if (
        isset($_FILES["images"]) &&
        !empty($_FILES["images"]["name"][0])
    ) {

        $allowedMimeTypes = [
            "image/jpeg",
            "image/png"
        ];

        $allowedExtensions = [
            "jpg",
            "jpeg",
            "png"
        ];


        for (
            $i = 0;
            $i < count($_FILES["images"]["name"]);
            $i++
        ) {

            $name =
                $_FILES["images"]["name"][$i];

            $tmpName =
                $_FILES["images"]["tmp_name"][$i];

            $size =
                $_FILES["images"]["size"][$i];

            $error =
                $_FILES["images"]["error"][$i];


            // Upload error
            if ($error !== UPLOAD_ERR_OK) {

                $errors[] =
                    "One of the images could not be uploaded.";

                continue;
            }


            // File size
            if ($size > 10 * 1024 * 1024) {

                $errors[] =
                    "Each image must be 10MB or smaller.";

                continue;
            }


            // File extension
            $extension = strtolower(
                pathinfo(
                    $name,
                    PATHINFO_EXTENSION
                )
            );


            if (
                !in_array(
                    $extension,
                    $allowedExtensions,
                    true
                )
            ) {

                $errors[] =
                    "Only PNG, JPG and JPEG images are allowed.";

                continue;
            }


            // MIME type
            $mimeType = mime_content_type(
                $tmpName
            );


            if (
                !in_array(
                    $mimeType,
                    $allowedMimeTypes,
                    true
                )
            ) {

                $errors[] =
                    "Invalid image file.";

                continue;
            }
        }
    }


    // ==================================================
    // RETURN VALIDATION ERRORS
    // ==================================================

    if (!empty($errors)) {

        echo json_encode([
            "success" => false,
            "message" => implode(
                " ",
                $errors
            )
        ]);

        exit();
    }


    // ==================================================
    // SAVE IMAGES
    // ==================================================

    if (
        isset($_FILES["images"]) &&
        !empty($_FILES["images"]["name"][0])
    ) {

        // Images are stored in View/uploads/
        $uploadDirectory =
            "../View/uploads/";


        // Create folder if it does not exist
        if (!is_dir($uploadDirectory)) {

            mkdir(
                $uploadDirectory,
                0777,
                true
            );
        }


        for (
            $i = 0;
            $i < count($_FILES["images"]["name"]);
            $i++
        ) {

            $originalName =
                $_FILES["images"]["name"][$i];

            $tmpName =
                $_FILES["images"]["tmp_name"][$i];


            $extension = strtolower(
                pathinfo(
                    $originalName,
                    PATHINFO_EXTENSION
                )
            );


            // Generate unique filename
            $newName =
                uniqid(
                    "property_",
                    true
                ) .
                "." .
                $extension;


            $destination =
                $uploadDirectory .
                $newName;


            if (
                move_uploaded_file(
                    $tmpName,
                    $destination
                )
            ) {

                $savedImages[] =
                    "uploads/" . $newName;
            }
        }
    }


    // ==================================================
    // CONVERT IMAGES TO JSON
    // ==================================================

    $imagesJson =
        json_encode($savedImages);


    // ==================================================
    // INSERT PROPERTY INTO DATABASE
    // ==================================================

    $created =
        $propertyModel->create(

            (int)$_SESSION["userId"],

            $title,

            $propertyType,

            $status,

            (float)$rent,

            $location,

            (int)$bedrooms,

            (int)$bathrooms,

            (int)$area,

            $availabilityDate,

            $description,

            $imagesJson
        );


    // ==================================================
    // RETURN RESULT
    // ==================================================

    if ($created) {

        echo json_encode([
            "success" => true,
            "message" =>
                "Property posted successfully.",
            "images" =>
                $savedImages
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" =>
                "Property could not be posted."
        ]);
    }

    exit();
}


// ======================================================
// OWNER DASHBOARD STATISTICS
// ======================================================

if ($action === "stats") {

    $stats =
        $propertyModel->getOwnerStats(
            (int)$_SESSION["userId"]
        );


    echo json_encode([
        "success" => true,
        "data" => $stats
    ]);

    exit();
}


// ======================================================
// UNKNOWN ACTION
// ======================================================

echo json_encode([
    "success" => false,
    "message" => "Unknown action."
]);

?>