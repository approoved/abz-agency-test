@extends('layouts.app')

@section('title')
    <title>User form</title>
@endsection

@section('styles')
    <style>
        .form-div {
            margin-bottom: 15px;
            margin-top: 15px;
        }
        .form-btn {
            min-width: 100px
        }
    </style>
@endsection

@section('content')
    <div class="form-div" id="messages"></div>
    <form onsubmit="return false">
        <div class="form-group form-div">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name">
        </div>
        <div class="form-group form-div">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="form-group form-div">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" placeholder="+380000000">
        </div>
        <div class="form-group form-div">
            <label for="position_id">Position</label>
            <select id="position_id" class="form-control form-control-md">
                <option selected>Select position</option>
            </select>
        </div>
        <div class="form-group form-div">
            <label for="photo">Photo</label>
            <input type="file" class="form-control form-control-file" id="photo">
        </div>
        <div id="buttons" class="form-group form-div">
            <button type="submit" class="btn btn-warning form-btn" onclick="getToken()">Get token</button>
            <button type="submit" class="btn btn-primary form-btn" onclick="sendForm()">Register</button>
        </div>
    </form>

    <script type="text/javascript">
        window.onload = buildPositionSelectOptions();

        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        function getCookie(name) {
            let nameEQ = name + "=";
            let ca = document.cookie.split(";");
            for(let i=0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === " ") c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

        function buildPositionSelectOptions()
        {
            axios.get("/api/positions")
                .then(function (response) {
                    response.data["positions"].forEach(function (item) {
                        const option = new Option(item["name"], item["id"]);
                        document.getElementById("position_id").append(option);
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function getToken()
        {
            axios.get("/api/token")
                .then(function (response) {
                    setCookie("token", response.data.token);
                    let div = buildAlertMessage("Token issued successfully. You can now register.", true);
                    document.getElementById("messages").append(div);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function sendForm()
        {
            const spinner = buildSpinner();
            document.getElementById("buttons").append(spinner);

            const formData = new FormData;

            formData.append("name", document.getElementById("name").value);
            formData.append("email", document.getElementById("email").value);
            formData.append("phone", document.getElementById("phone").value);
            formData.append("position_id", document.getElementById("position_id").value);
            formData.append("photo", document.getElementById("photo").files[0]);

            const collection = document.querySelectorAll(".text-danger");
            collection.forEach(function (item) {
                item.remove();
            });

            axios.post("/api/users", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    "Authorization": getCookie("token"),
                }
            })
                .then(function (response) {
                    spinner.remove();

                    let div = buildAlertMessage("New user successfully registered.", true)
                    document.getElementById("messages").append(div);
                })
                .catch(function (error) {
                    spinner.remove();

                    if (error.response.status === 401) {
                        let div = buildAlertMessage("Unauthorized. Get registration token first.", false)
                        document.getElementById("messages").append(div);
                    }

                    if (error.response.status === 409) {
                        let div = buildAlertMessage("User with this phone or email already exists.", false)
                        document.getElementById("messages").append(div);
                    }

                    if (error.response.status === 422) {
                        let errors = error.response.data["fails"]["0"];

                        for (let key in errors) {
                            const small = document.createElement("small");
                            small.setAttribute("id", key + "-error");
                            small.setAttribute("class", "form-text text-danger");
                            small.textContent = errors[key];

                            const div = document.getElementById(key).parentElement;
                            div.append(small);
                        }
                    }
                });
        }

        function buildAlertMessage(message, success)
        {
            let div = document.createElement("div");
            if (success === true) {
                div.setAttribute("class", "alert alert-success alert-dismissible fade show");
            } else div.setAttribute("class", "alert alert-danger alert-dismissible fade show");
            div.setAttribute("role", "alert");
            div.textContent = message;

            let button = document.createElement("button");
            button.setAttribute("type", "button");
            button.setAttribute("class", "close");
            button.setAttribute("data-dismiss", "alert");
            button.setAttribute("aria-label", "Close");

            let span = document.createElement("span");
            span.setAttribute("area-hidden", "true");
            span.innerHTML = "&times;";

            button.append(span);
            div.append(button);

            const collection = document.querySelectorAll(".alert-dismissible");
            collection.forEach(function (item) {
                item.remove();
            })

            return div;
        }

        function buildSpinner()
        {
            let div = document.createElement("div");
            div.setAttribute("class", "spinner-border text-primary");
            div.setAttribute("role", "status");

            let span = document.createElement("span");
            span.setAttribute("class", "sr-only");
            span.innerText = "Loading...";

            div.append(span);

            return div;
        }
    </script>
@endsection
