console.log("manager.js loaded");

function escapeHTML(value)
{
    return String(value ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;");
}


async function getJSON(url)
{
    let response = await fetch(url);

    return await response.json();
}


async function postJSON(url, data)
{
    let response = await fetch(
        url,
        {
            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify(data)
        }
    );

    return await response.json();
}


/* Dashboard */

/* Dashboard */

async function loadDashboard()
{
    console.log("loadDashboard started");

    let result = await getJSON(
        "/HouseRentalManagementSystem/Controller/AjaxController.php?action=dashboard"
    );

    console.log(result);

    if (result.success) {
        document.getElementById("totalPosts").innerHTML = result.data.total;
        document.getElementById("acceptedPosts").innerHTML = result.data.accepted;
        document.getElementById("rejectedPosts").innerHTML = result.data.rejected;
        document.getElementById("pendingPosts").innerHTML = result.data.pending;
    }
}


/* Posts */

async function loadPosts(status)
{
    let result = await getJSON(
        "../Controller/AjaxController.php?action=posts&status=" +
        encodeURIComponent(status)
    );

    let table =
        document.getElementById("postTable");

    table.innerHTML = "";

    if (!result.success) {
        return;
    }

    result.data.forEach(function (post) {

        let buttons = "-";

       if (post.status.toLowerCase() == "pending")
{
    buttons =
        "<button class='approve' " +
        "onclick=\"changeStatus(" +
        post.propertyID +
        ", 'Accepted')\">" +
        "Approve</button> " +

        "<button class='reject' " +
        "onclick=\"changeStatus(" +
        post.propertyID +
        ", 'Rejected')\">" +
        "Reject</button>";
}

        table.innerHTML +=
            "<tr>" +

            "<td>" +
            escapeHTML(post.Title) +
            "</td>" +

            "<td>" +
            escapeHTML(post.ownerName) +
            "</td>" +

            "<td>" +
            escapeHTML(post.location) +
            "</td>" +

            "<td>$" +
            escapeHTML(post.rent) +
            "</td>" +

            "<td>" +
            escapeHTML(post.status) +
            "</td>" +

            "<td>" +
            buttons +
            "</td>" +

            "</tr>";
    });
}


async function changeStatus(propertyID, status)
{
    let result = await postJSON(
        "../Controller/AjaxController.php?action=postStatus",

        {
            propertyID: propertyID,
            status: status
        }
    );

    document.getElementById("postMessage").innerHTML =
        escapeHTML(result.message);

    if (result.success) {
        loadPosts("all");
    }
}


/* Payments */

/* Payments */

async function loadPayments(search)
{
    let result = await getJSON(
        "../Controller/AjaxController.php?action=payments&search=" +
        encodeURIComponent(search)
    );

    console.log(result);

    let table =
        document.getElementById("paymentTable");

    table.innerHTML = "";

    if (!result.success) {
        return;
    }

    result.data.forEach(function (payment) {

        table.innerHTML +=
            "<tr>" +

            "<td>" +
            escapeHTML(payment.clientName) +
            "</td>" +

            "<td>" +
            escapeHTML(payment.propertyTitle) +
            "</td>" +

            "<td>$" +
            escapeHTML(payment.amount) +
            "</td>" +

            "<td>" +
            escapeHTML(payment.paymentDate) +
            "</td>" +

            "<td>" +
            escapeHTML(payment.status) +
            "</td>" +

            "</tr>";
    });
}


/* Notifications */

async function loadClients()
{
    let result = await getJSON(
        "../Controller/AjaxController.php?action=clients"
    );

    let client =
        document.getElementById("client");

    client.innerHTML =
        "<option value=''>Select Client</option>";

    result.data.forEach(function (row) {

        client.innerHTML +=
            "<option value='" +
            row.userID +
            "'>" +
            escapeHTML(row.userName) +
            "</option>";
    });
}


async function loadProperties(clientID)
{
    let result = await getJSON(
        "../Controller/AjaxController.php?action=clientProperties&clientID=" +
        encodeURIComponent(clientID)
    );

    let property =
        document.getElementById("property");

    property.innerHTML =
        "<option value=''>Select Property</option>";

    result.data.forEach(function (row) {

        let option =
            document.createElement("option");

        option.value = row.propertyID;

        option.innerHTML =
            escapeHTML(row.Title);

        option.dataset.amount =
            row.amount ?? "";

        property.appendChild(option);
    });
}


function showAmount()
{
    let property =
        document.getElementById("property");

    let amount =
        document.getElementById("amount");

    let selected =
        property.options[property.selectedIndex];

    amount.value =
        selected.dataset.amount || "N/A";
}


function validateNotification()
{
    let valid = true;

    let client =
        document.getElementById("client");

    let property =
        document.getElementById("property");

    let dueDate =
        document.getElementById("dueDate");

    let message =
        document.getElementById("message");

    document.getElementById("clientError").innerHTML = "";
    document.getElementById("propertyError").innerHTML = "";
    document.getElementById("dueDateError").innerHTML = "";
    document.getElementById("messageError").innerHTML = "";

    if (client.value == "") {

        document.getElementById("clientError").innerHTML =
            "Select client";

        valid = false;
    }

    if (property.value == "") {

        document.getElementById("propertyError").innerHTML =
            "Select property";

        valid = false;
    }

    if (dueDate.value == "") {

        document.getElementById("dueDateError").innerHTML =
            "Due date required";

        valid = false;
    }

    if (message.value.trim() == "") {

        document.getElementById("messageError").innerHTML =
            "Message required";

        valid = false;
    }

    return valid;
}


async function sendNotification()
{
    if (!validateNotification()) {
        return;
    }

    let result = await postJSON(
        "../Controller/AjaxController.php?action=sendNotification",

        {
            clientID:
                Number(
                    document.getElementById("client").value
                ),

            propertyID:
                Number(
                    document.getElementById("property").value
                ),

            dueDate:
                document.getElementById("dueDate").value,

            message:
                document.getElementById("message").value.trim()
        }
    );

    document.getElementById("notificationMessage").innerHTML =
        escapeHTML(result.message);

    if (result.success) {

        document.getElementById("message").value = "";
        document.getElementById("dueDate").value = "";

        loadNotifications();
    }
}


async function loadNotifications()
{
    let result = await getJSON(
        "../Controller/AjaxController.php?action=notifications"
    );

    let table =
        document.getElementById("notificationTable");

    table.innerHTML = "";

    result.data.forEach(function (row) {

        table.innerHTML +=
            "<tr>" +

            "<td>" +
            escapeHTML(row.clientName) +
            "</td>" +

            "<td>" +
            escapeHTML(row.propertyTitle) +
            "</td>" +

            "<td>" +
            (
                row.amount == null
                ? "N/A"
                : "$" + escapeHTML(row.amount)
            ) +
            "</td>" +

            "<td>" +
            escapeHTML(row.dueDate) +
            "</td>" +

            "<td>" +
            escapeHTML(row.sentDate) +
               "</td>" +

            "<td>Sent</td>" +

            "</tr>";
    });
}


/* Page Load */

document.addEventListener(
    "DOMContentLoaded",
    function ()
    {

        if (window.pageName == "dashboard") {

            loadDashboard();
        }


        if (window.pageName == "posts") {

            loadPosts("all");

            document
                .querySelectorAll(".filterButton")
                .forEach(function (button) {

                    button.addEventListener(
                        "click",
                        function ()
                        {

                            document
                                .querySelectorAll(".filterButton")
                                .forEach(function (btn) {
                                    btn.classList.remove(
                                        "active-filter"
                                    );
                                });

                            button.classList.add(
                                "active-filter"
                            );

                            loadPosts(
                                button.dataset.status
                            );
                        }
                    );

                });
        }


        if (window.pageName == "payments") {

    loadPayments("");

    document
        .getElementById("search")
        .addEventListener(
            "input",
            function ()
            {
                loadPayments(this.value);
            }
        );
}


        if (window.pageName == "notifications") {

            loadClients();

            loadNotifications();

            document
                .getElementById("client")
                .addEventListener(
                    "change",
                    function ()
                    {
                        loadProperties(this.value);
                    }
                );

            document
                .getElementById("property")
                .addEventListener(
                    "change",
                    showAmount
                );

            document
                .getElementById("sendButton")
                .addEventListener(
                    "click",
                    sendNotification
                );
        }

    }
);
