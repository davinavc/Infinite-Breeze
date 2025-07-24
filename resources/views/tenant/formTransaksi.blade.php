@extends('layouts.app-tenant')

@section('title', 'Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Transaction</h1>
        <div class="header-button">
            <button id="toggleDarkMode">
                <span class="dropdown-icon material-symbols-outlined">dark_mode</span>
            </button>
            <button>
                <span class="dropdown-icon material-symbols-outlined">account_circle</span>
            </button>
        </div>
    </header>

    <div class="dashboard-content">
            <!-- Staff Commission Table -->
            <div class="staff-list">
                <h2>Data Event</h2>
                @if(session('success'))
                    <div class="success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('tenant.transaction.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tenant_id" value="{{ $tenant_id }}">
                    <input type="hidden" name="event_id" value="{{ $event_id }}">
                    <div class="form-column-2">
                        <div class="form-group">
                            <label for="papan_nama">Board Name</label>
                            <input type="text" name="papan_nama" id="papan_nama" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_pemesan">Registered By</label>
                            <input type="text" name="nama_pemesan" id="nama_pemesan" required>
                        </div>

                        <div class="form-group">
                            <label for="watt_listrik">Electricity Usage (In Ampere, 1 Ampere = 220 Watt)</label>
                            <input type="number" name="watt_listrik" id="watt_listrik" required>
                            <p style="font-size:12px;">*We support up to {{ $event->supported_electricity }} Amperes. Additional change apply for usage above {{ $event->supported_electricity }} Amperes</p>
                        </div>

                        <div class="form-group">
                            <label for="listrik_24_jam">24 Hours Electricity?</label>
                            <select name="listrik_24_jam" required>
                                <option value="" disabled selected>Pilih Penggunaan Listrik</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="referral_code">Referral Code</label>
                            <input type="text" name="referral_code" id="referral_code" style="text-transform: uppercase;">
                        </div>

                        <div class="form-group">
                            <label for="bukti_transaksi">Payment Proof</label>
                            <p style="font-size:12px;">Transfer ke rekening BCA a.n. PT INFINITI CIPTA ABADI </p>
                            <b><p style="font-size:12px;">162 6800 999</p></b>
                            <input type="file" name="bukti_transaksi" id="bukti_transaksi" accept="image/*">
                        </div>
                        <input type="hidden" name="total_price" id="total_price">

                    </div>

                    <h3>Sub Total</h3>
                    <div class="form-column-2">
                        
                        <div class="form-group">
                
                            <p>Booth Price</p>
                            <p>Additional Electricity</p>
                            <h3>Total</h3>
                        </div>

                        <div class="form-group subdata">
                            <div id="price-data"
                                data-harga="{{ $event->harga }}"
                                data-electricity="{{ $event->supported_electricity }}"
                                data-tarif="{{ $event->price_per_watt }}" style="display: none;">
                            </div>
                            <p>Rp {{ number_format($event->harga, 0, ',', '.') }}</p>
                            <p id="listrik-cost">Rp 0</p>
                            <h3 id="total-cost">Rp {{ number_format($event->harga, 0, ',', '.') }}</h3>
                        </div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined" style="margin-right:5px;">payments</span>
                            Pay
                        </button>
                        <a href="{{ route('dashboard.tenant.transaction') }}" class="add-staff btn-cancel">
                            <span class="material-symbols-outlined">close</span>
                            <span class="nav-label">Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
