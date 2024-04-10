<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceController\AddStockRequest;
use App\Http\Requests\InvoiceController\DeleteStockRequest;
use App\Http\Requests\InvoiceController\EditStockRequest;
use App\Http\Requests\InvoiceController\MoveStockRequest;
use App\Http\Requests\InvoiceController\StoreRequest;
use App\Models\Invoice;
use App\Models\StockControl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Invoice::query();

        if (!empty($start_date)) {
            $query->where('invoice_date', '>=', $start_date);
        }

        if (!empty($end_date)) {
            $query->where('invoice_date', '<=', $end_date);
        }

        // Dodaj sortowanie, aby faktury z ilością równą zero były na końcu
        $query->orderByRaw('quantity = 0');

        $invoices = $query->paginate(20);

        return view('invoice_list', ['invoices' => $invoices]);
    }
    public function create()
    {
        return view('invoice_create');
    }
    public function store(StoreRequest $request)
    {
        $invoice = new Invoice($request->validated());
        $validatedData = $request->validated();
        $invoice->invoice_quantity = $validatedData['invoice_quantity'];
        $invoice->save();
        return redirect()->route('invoices.index');
    }
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        return view('invoice_edit', ['invoice' => $invoice]);
    }

    /**
     * @param EditStockRequest $requset
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Znajdź fakturę do aktualizacji
        $invoice = Invoice::findOrFail($id);
        // Zaktualizuj atrybuty faktury na podstawie danych z formularza
        $invoice->invoice_number = $request->input('invNumber');
        $invoice->product_name = $request->input('invProductName');
        $invoice->quantity = $request->input('invQuantity');
        $invoice->price = $request->input('invPrice');
        $invoice->place = $request->input('invPlace');
        $invoice->invoice_date = $request->input('invDate');
        $invoice->vat_rate = $request->input('quantityToRemove');

        // Zapisz zmiany
        $invoice->save();

        // Przekieruj użytkownika po aktualizacji
        return redirect()->route('invoices.index')->with('success', 'Faktura została zaktualizowana pomyślnie.');
    }



    public function destroy(Request $request)
    {
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $query = Invoice::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('product_name', 'like', "%$search%")
                    ->orWhere('invoice_number', 'like', "%$search%");
            });
        }

        if (!empty($start_date)) {
            $query->where('invoice_date', '>=', $start_date);
        }

        if (!empty($end_date)) {
            $query->where('invoice_date', '<=', $end_date);
        }

        $results = $query->paginate(20);

        return view('invoice_search', ['results' => $results]);
    }
    public function deleteStock(DeleteStockRequest $request)
    {
        $request = $request->validated();
        $id = $request ['id'];
        $invoice_number = $request ['invoice_number'];
        $product_name = $request ['product_name'];
        $quantityToRemove = $request ['quantityToRemove'];
        $invDate = $request ['invDate'];
        $invoice = Invoice::find($id);
        $invoice->quantity = $invoice->quantity - $quantityToRemove;
        $invoice->save();
        StockControl::create([
            'title' => 'Usuń',
            'invoice_id' => $invoice_number,
            'product_name' => $product_name,
            'quantity' => $quantityToRemove, // ujemna ilość oznacza odejmowanie z zapasów
            'operation_date' => $invDate, // lub inna data operacji
            'move_to' => '',
        ]);
        return redirect()->route('invoices.index')->with('success', 'Liczbe sztuk pomyślnie odjęto.');
    }
    public function addStock(AddStockRequest $req)
    {
        $req = $req->validated();
        $id = $req ['id'];
        $invoice_number = $req ['invoice_number'];
        $quantityToAdd = $req['quantityToAdd'];
        $product_name = $req ['product_name'];
        $invDate = $req ['invDate'];
        $invoice = Invoice::find($id);
        $invoice->quantity = $invoice->quantity + $quantityToAdd;
        $invoice->save();
        StockControl::create([
            'title' => 'Dodaj',
            'invoice_id' => $invoice_number,
            'product_name' => $product_name,
            'quantity' => $quantityToAdd, // ujemna ilość oznacza odejmowanie z zapasów
            'operation_date' =>  $invDate, // lub inna data operacji
            'move_to' => '', // Możesz dostosować to pole do swoich potrzeb
        ]);
        return redirect()->route('invoices.index')->with('success', 'Liczbe sztuk pomyślnie dodano.');
    }
    public function moveStock(MoveStockRequest $request)
    {
        dd($request->all());

        // Pobierz zwalidowane dane z żądania
        $validatedData = $request->validated();

        // Pobierz potrzebne dane z żądania
        $id = $validatedData['id'];
        $invoiceNumber = $validatedData['invoice_number'];
        $productName = $validatedData['product_name'];
        $quantityToAdd = $validatedData['quantityToAdd'];
        $operationDate = $validatedData['operationDateToMove'];
        $placeToMove = $validatedData['placeToMove'];

        // Znajdź fakturę do aktualizacji
        $invoice = Invoice::find($id);

        // Dodaj ilość do faktury
        $invoice->quantity += $quantityToAdd;
        $invoice->save();

        // Stwórz nowy rekord w StockControl
        StockControl::create([
            'title' => 'Przeniesienie',
            'invoice_id' => $invoiceNumber,
            'product_name' => $productName,
            'quantity' => $quantityToAdd,
            'operation_date' => $operationDate,
            'move_to' => $placeToMove,
        ]);

        // Przekieruj użytkownika po zakończeniu operacji
        return redirect()->route('invoices.index')->with('success', 'Pomyślnie przeniesiono sztuki.');
    }
}

