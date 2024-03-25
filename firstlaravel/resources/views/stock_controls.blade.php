<!-- resources/views/stock_controls.blade.php -->

@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 10vh">
        <!--Header-->
        <div class="row">
            <!--Header name-->
            <h1 class="strong d-flex justify-content-center mt-4">Archiwum Faktur</h1>
        </div>
        <!--Search bar-->
        <div class="d-flex justify-content-center mb-4">
            <nav class="navbar navbar-light bg-light">
                <!--Search form-->
                <form method="GET" action="{{ route('invoices.search') }}" class="form-inline d-flex">
                    <!--Search by name or number-->
                    <input name="search" class="form-control w-5" type="search" placeholder="Nazwa/Numer"
                           aria-label="Search">
                    <!--Search by start date-->
                    <input name="start_date" class="form-control w-3" type="date" placeholder="Start Date"
                           aria-label="Start Date">
                    <!--Search by end date-->
                    <input name="end_date" class="form-control w-3" type="date" placeholder="End Date"
                           aria-label="End Date">
                    <!--Search button-->
                    <button class="btn btn-outline-success" type="submit">Wyszukaj</button>
                </form>
            </nav>
        </div>
        <!--Table style-->
        <div class="row justify-content-center ">
            <div class="col-8">
                <!--Table-->
                <table class="table table-bordered text-white text-center " style="background-color: #1E2F47;">
                    <!--Table head style-->
                    <thead class="thead-dark">
                    <!--Table head writing-->
                    <tr style="background-color: #111E2B;" class="text-white">
                        <th scope="col ">Operacja</th>
                        <th scope="col">Numer faktury</th>
                        <th scope="col">Nazwa produktu</th>
                        <th scope="col">Ilość</th>
                        <th scope="col">Data operacji</th>
                        <th scope="col"></th>

                    </tr>
                    </thead>
                    <!--Table content-->
                    <tbody>
                    <!--Printing all records from the invoice table-->
                    @foreach($stockControls as $stockControl)
                        <!--Table content writing-->
                        <tr>
                            <td>{{ $stockControl->title }}</td>
                            <td> {{ $stockControl->invoice->invoice_number }}</td>
                            <td> {{ $stockControl->invoice->product_name }}</td>
                            <td>{{ $stockControl->quantity }}</td>
                            <td>{{ $stockControl->operation_date }}</td>
                            <td class="col d-flex justify-content-start">

                                <!-- Edit button-->
                                <a href=""
                                   class="btn btn-primary m-auto">
                                    <i class="fas fa-edit"></i>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection