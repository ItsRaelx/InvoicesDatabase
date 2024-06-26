<!-- Delete pop-up panel -->
<div class="modal fade" id="edit-modal-{{$id}}">
    <div class="modal-dialog modal-dialog-centered">">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    Edytujesz faktury nr {{ $invoice->invoice_number }}
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <!-- Routing do napisania, poprawa na js wyswietlanie pop-upów oraz nazy id itp -->
            <form method="POST" action="{{route('invoices.update', ['id'=>$invoice->id])}}">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <label for="invNumber">Numer faktury:</label>
                        <input type="text" id="invNumber" name="invNumber" class="form-control" value="{{ $invoice->invoice_number }}">
                        <small id="quantityHelp" class="form-text text-muted">Podaj poprawiony numer faktury.</small>
                    </div>

                    <div class="row">
                        <label for="invProductName">Nazwa produktu:</label>
                        <input type="text" id="invProductName" name="invProductName" class="form-control"
                               value="{{ $invoice->product_name}}">
                        <small id="quantityHelp" class="form-text text-muted">Podaj poprawioną nazwe produktu.</small>
                    </div>
                    <div class="row">
                        <label for="invDate">Data wystawienia faktury:</label>
                        <input type="date" value="{{ $invoice->invoice_date->format('Y-m-d')}}" id="invDate"
                               name="invDate" class="form-control">
                        <small id="quantityHelp" class="form-text text-muted">Podaj poprawioną date wystawienia
                            faktury.</small>
                    </div>
                    <div class="row">
                        <label for="invQuantity">Ilość sztuk:</label>
                        <input type="number" value="{{ $invoice->quantity}}" min="0" id="invQuantity" name="invQuantity"
                               class="form-control">
                        <small id="quantityHelp" class="form-text text-muted">Podaj poprawioną ilość sztuk.</small>
                    </div>
                    <div class="row">
                        <label for="invPrice">Cena:</label>
                        <input type="number" value="{{ $invoice->price}}" id="invPrice" name="invPrice"
                               class="form-control">
                        <small id="quantityHelp" class="form-text text-muted">Podaj poprawioną cene.</small>
                    </div>
                    <div class="row">
                        <label for="invPlace">Miejsce:</label>
                        <input type="text" value="{{ $invoice->place}}" id="invPlace" name="invPlace"
                               class="form-control">
                        <small id="quantityHelp" class="form-text text-muted">Podaj poprawione miejsce.</small>
                    </div>
                    <div class="row">
                        <label for="quantityToRemove">Podatek VAT:</label>
                        <input type="number" max="100" min="0"  value="{{ $invoice->vat_rate}}" id="quantityToRemove" name="quantityToRemove"
                               class="form-control">
                        <small id="quantityHelp" class="form-text text-muted">Podaj poprawiony podatek VAT.</small>
                    </div>
                    <input type="hidden" name="search" value="{{$search ?? null}}"/>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="deleteButton"
                            data-invoice-id="{{ $invoice->id }}">
                        Zapisz
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
                </div>
            </form>
        </div>
    </div>
</div>
