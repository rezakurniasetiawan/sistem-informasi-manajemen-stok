<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />
    <link href="https://unpkg.com/feather-icons@4.28.0/dist/feather.css" rel="stylesheet">
    <title>Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            list-style: none;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-item .page-link {
            border-radius: 0.25rem;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .pagination .page-item .page-link:hover {
            background-color: #e9ecef;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #f8f9fa;
        }


        .password-wrapper {
            display: flex;
            align-items: center;
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            cursor: pointer;
        }
    </style>
    <style>
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table.styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 1000px;
        }

        .styled-table thead tr {
            background-color: #222E3C;
            color: #ffffff;
            text-align: center;
        }

        .styled-table th,
        .styled-table td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: right;
            vertical-align: middle;
        }

        .styled-table td:first-child,
        .styled-table td:nth-child(2),
        .styled-table th:first-child,
        .styled-table th:nth-child(2) {
            text-align: center;
        }

        .styled-table tfoot tr {
            background-color: #f1f1f1;
            font-weight: bold;
        }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        @include('dashboard.components.sidebar')

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                @include('dashboard.components.navbar')
            </nav>

            <main class="content">
