<?php

session_start();

require_once "../db/db.php";
require_once "../Model/Property.php";

header("Content-Type: application/json");


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


$propertyModel = new Property();

$action = $_GET["action"] ?? "";


<<<<<<< HEAD
// new property create 

=======
>>>>>>> addf976 (Final updated owner)
if ($action === "create") {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {

        echo json_encode([
            "success" => false,
            "message" => "Invalid request."
        ]);

        exit();
    }

    $title = trim( $_POST["title"] ?? "");

    $propertyType = trim($_POST["propertyType"] ?? "");

    $location = trim($_POST["location"] ?? "");

    $rent = trim($_POST["rent"] ?? "");

    $bedrooms = trim($_POST["bedrooms"] ?? "");

    $bathrooms = trim($_POST["bathrooms"] ?? "");

    $area = trim($_POST["area"] ?? "");

    $availabilityDate = trim($_POST["availabilityDate"] ?? "");

    $description = trim($_POST["description"] ?? "");

    $status = "AVAILABLE";

    $errors = [];


    if ($title === "") {

<<<<<<< HEAD
        $errors[] =
            "Property title is required.";

    } elseif (strlen($title) > 200) {

        $errors[] =
            "Property title is too long.";
=======
        $errors[] = "Property title is required.";

    } elseif (strlen($title) > 200) {

        $errors[] = "Property title is too long.";
>>>>>>> addf976 (Final updated owner)
    }


    $allowedTypes = ["Villa","Apartment","House","Townhouse","Cabin","Studio"];

    if ($propertyType === "") {

        $errors[] = "Property type is required.";

    } 
    
    elseif  (!in_array($propertyType,$allowedTypes,true)) {

        $errors[] = "Invalid property type.";
    }


    if ($location === "") {

        $errors[] ="Location is required.";

    } 
    
    elseif (strlen($location) > 255) {

        $errors[] ="Location is too long.";
    }


    if ($rent === "") {

        $errors[] = "Monthly rent is required.";

    } 
    elseif (!is_numeric($rent) || (float)$rent <= 0) {

        $errors[] ="Monthly rent must be greater than 0.";
    }


<<<<<<< HEAD
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
=======
    if ( $bedrooms === "" ||filter_var($bedrooms,FILTER_VALIDATE_INT) === false ||(int)$bedrooms < 0) 
    {

        $errors[] ="Bedrooms must be 0 or more.";
>>>>>>> addf976 (Final updated owner)
    }


    if ( $bathrooms === "" || filter_var( $bathrooms,FILTER_VALIDATE_INT) === false || (int)$bathrooms < 0)
<<<<<<< HEAD
     {
=======
    {
>>>>>>> addf976 (Final updated owner)

        $errors[] = "Bathrooms must be 0 or more.";
    }

<<<<<<< HEAD
    if (
        $area === "" || filter_var($area,FILTER_VALIDATE_INT ) === false ||(int)$area <= 0) 
=======
    if ( $area === "" || filter_var($area,FILTER_VALIDATE_INT ) === false ||(int)$area <= 0) 
>>>>>>> addf976 (Final updated owner)
    {
        $errors[] = "Area must be greater than 0.";
    }


    if ($availabilityDate === "") {

        $errors[] = "Availability date is required.";

    } 
    else {

        $date = DateTime::createFromFormat("Y-m-d", $availabilityDate);

        if (!$date || $date->format("Y-m-d") !== $availabilityDate) {

            $errors[] = "Invalid availability date.";
        }
    }


    if (strlen($description) > 1000) {

        $errors[] = "Description cannot exceed 1000 characters.";
    }

// image size check and uploads in the folder
   
    $savedImages = [];

    if (isset($_FILES["images"]) &&!empty($_FILES["images"]["name"][0])) 
        {

        $allowedMimeTypes = ["image/jpeg","image/png"];

        $allowedExtensions = ["jpg","jpeg","png"];

        for ( $i = 0; $i < count($_FILES["images"]["name"]); $i++) 
            {

            $name = $_FILES["images"]["name"][$i];

            $tmpName = $_FILES["images"]["tmp_name"][$i];

            $size = $_FILES["images"]["size"][$i];

            $error = $_FILES["images"]["error"][$i];


            if ($error !== UPLOAD_ERR_OK) {

                $errors[] = "One of the images could not be uploaded.";

                continue;
            }


            if ($size > 10 * 1024 * 1024) {

                $errors[] = "Each image must be 10MB or smaller.";
                continue;
            }

            $extension = strtolower( pathinfo( $name, PATHINFO_EXTENSION ));

            if ( !in_array( $extension, $allowedExtensions,true)) {

                $errors[] = "Only PNG, JPG and JPEG images are allowed.";

                continue;
            }

            $mimeType = mime_content_type( $tmpName );

            if (!in_array($mimeType,$allowedMimeTypes,true)) {

                $errors[] = "Invalid image file.";
                continue;
            }
        }
    }


    if (!empty($errors)) {

        echo json_encode([
            "success" => false,
            "message" => implode(" ", $errors)
        ]);

        exit();
    }


    if ( isset($_FILES["images"]) && !empty($_FILES["images"]["name"][0])) {

        $uploadDirectory = "../View/uploads/";

<<<<<<< HEAD
// jodi folder exit nh thake then create new directory

=======
>>>>>>> addf976 (Final updated owner)
        if (!is_dir($uploadDirectory)) 
        {
            mkdir( $uploadDirectory,0777,true);
        }


        for ( $i = 0; $i < count($_FILES["images"]["name"]); $i++) {

            $originalName = $_FILES["images"]["name"][$i];

            $tmpName = $_FILES["images"]["tmp_name"][$i];

            $extension = strtolower(
                pathinfo( $originalName, PATHINFO_EXTENSION )
            );

<<<<<<< HEAD
// new filename create korbe every image upload r pore
=======
// create new filename for every image after uploaded
>>>>>>> addf976 (Final updated owner)

            $newName = uniqid( "property_",true) ."." .$extension;

            $destination = $uploadDirectory.$newName;

            if (
                move_uploaded_file( $tmpName, $destination)) {

                $savedImages[] = "uploads/" . $newName;
            }
        }
    }

<<<<<<< HEAD

// image convert to json format 

=======
>>>>>>> addf976 (Final updated owner)
    json_encode($savedImages);

    $created = $propertyModel->create(

            (int)$_SESSION["userId"],$title, $propertyType,$status,(float)$rent, $location,
            (int)$bedrooms,(int)$bathrooms, (int)$area, $availabilityDate,$description,$imagesJson
        );


    if ($created) {

        echo json_encode([
            "success" => true,
            "message" =>"Property posted successfully.",
            "images" => $savedImages
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Property could not be posted."
        ]);
    }

    exit();
<<<<<<< HEAD
}


// dashboard statistics convert to JSON format 
=======
} 
>>>>>>> addf976 (Final updated owner)

if ($action === "stats") {

    $stats = $propertyModel-> getOwnerStats((int)$_SESSION["userId"]);

    echo json_encode([
        "success" => true,
        "data" => $stats
    ]);

    exit();
}

echo json_encode([
    "success" => false,
    "message" => "Unknown action."
]);

?>