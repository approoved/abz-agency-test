@extends('layouts.app')

@section('title')
    <title>User list</title>
@endsection

@section('styles')
    <style>
        .table-wrapper {
            min-width: 1000px;
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }
        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }
        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }
        table.table tr th, table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }
        table.table tr th:first-child {
            width: 60px;
        }
        table.table tr th:last-child {
            width: 100px;
        }
        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }
        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }
        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }
        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }
        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
        }
        table.table td a:hover {
            color: #2196F3;
        }
        table.table td i {
            font-size: 19px;
        }
        .pagination {
            float: right;
            margin: 0 0 5px;
        }
        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }
        .pagination li a:hover {
            color: #666;
        }
        .pagination li.active a:hover {
            background: #0397d6;
        }
        .pagination li.disabled i {
            color: #ccc;
        }
        .pagination li i {
            font-size: 16px;
            padding-top: 6px
        }
        .div-center {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="table-wrapper">
        <ul id="paginationNext" class="pagination"></ul>
        <ul id="paginationPrev" class="pagination"></ul>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
        <div id="showMoreDiv" class="div-center"></div>
    </div>

    <script type="text/javascript">
        window.onload = getUserList();

        function getUserList(page, preservePrevious = false)
        {
            axios.get('/api/users', {
                params: {
                    count: 6,
                    page: page,
                }
            })
                .then(function (response) {
                    const tableData = response.data["users"].map(function (item) {
                        return (
                            `<tr class="user-card">
                                <td>${item["id"]}</td>
                                <td><img src=${item["photo"]} class="avatar" alt="Avatar"></td>
                                <td>${item["name"]}</td>
                                <td>${item["email"]}</td>
                                <td>${item["phone"]}</td>
                                <td>${item["position"]}</td>
                            </tr>`
                        );
                    }).join("");
                    const tableBody = document.getElementById("tableBody");
                    if (preservePrevious === true) {
                        tableBody.innerHTML += tableData;
                    } else {
                        tableBody.innerHTML = tableData;
                    }

                    const paginationPrev = document.querySelector("#paginationPrev");

                    if (preservePrevious === false) {
                        let previous = document.querySelectorAll(".previous");
                        previous.forEach(function (item) {
                            item.remove();
                        })

                        if (response.data.links["prev_url"] === null) {
                            paginationPrev.innerHTML += `<li class="page-item previous disabled"><a class="page-link" href="#">Previous</a></li>`;
                        } else {
                            paginationPrev.innerHTML += `<li class="page-item previous"><a class="page-link" onclick=getUserList(${response.data.page - 1})>Previous</a></li>`
                        }
                    }

                    let next = document.querySelectorAll(".next");
                    next.forEach(function (item) {
                        item.remove();
                    })
                    const paginationNext = document.querySelector("#paginationNext");
                    if (response.data.links["next_url"] === null) {
                        paginationNext.innerHTML += `<li class="page-item next disabled"><a class="page-link" href="#">Next</a></li>`;
                    } else {
                        paginationNext.innerHTML += `<li class="page-item next"><a class="page-link" onclick=getUserList(${response.data.page + 1})>Next</a></li>`
                    }

                    if (response.data.links["next_url"] !== null) {
                        const showMore = document.querySelector("#showMoreDiv");
                        showMore.innerHTML = `<button id="showMoreBtn" class="vertical-center btn btn-primary" onclick="getUserList(${response.data.page + 1}, true)">Show More</button>`;
                    } else {
                        document.querySelector("#showMoreBtn").remove();
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    </script>
@endsection
