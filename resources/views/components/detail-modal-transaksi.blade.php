{{-- DETAIL MODAL --}}
<div class="detail-modal-overlay" id="detailModal">

    <div class="detail-modal">

        {{-- CLOSE --}}
        <button class="close-detail" onclick="closeDetailModal()">
            ✕
        </button>

        <h2 class="detail-title">Detail Transaksi</h2>

        <div class="detail-content">

            {{-- ================= LEFT ================= --}}
            <div class="detail-column">

                <div class="detail-box">
                    <label>Nama Lapak</label>
                    <p id="detailNama"></p>
                </div>

                <div class="detail-box">
                    <label>Jenis Kolam</label>
                    <p id="detailJenis"></p>
                </div>

                <div class="detail-box">
                    <label>Harga / Orang</label>
                    <p id="detailHarga"></p>
                </div>

                <div class="detail-box">
                    <label>Bukti Transfer</label>
                    <img id="detailBuktiTf" class="detail-bukti-img" onclick="openImgPreview(this.src)">
                </div>

            </div>

            {{-- ================= RIGHT ================= --}}
            <div class="detail-column">

                <div class="detail-box" id="boxUser">
                    <label>Nama User</label>
                    <p id="detailUser"></p>
                </div>

                <div class="detail-box">
                    <label>Tanggal Booking</label>
                    <p id="detailTanggal"></p>
                </div>

                <div class="detail-box">
                    <label>Jam Booking</label>
                    <p id="detailJam"></p>
                </div>

                <div class="detail-box">
                    <label>Jumlah Orang</label>
                    <p id="detailJumlah"></p>
                </div>

                <div class="detail-box">
                    <label>Metode Pembayaran</label>
                    <p id="detailMetode"></p>
                </div>

                <div class="detail-box">
                    <label>Total Harga</label>
                    <p id="detailTotal"></p>
                </div>

                <div class="detail-box">
                    <label>Status</label>
                    <div id="detailStatus"></div>
                </div>

                <div class="detail-box">
                    <div id="detailRejectReason" style="display:none;"></div>
                </div>

                {{-- ================= ACTION BUTTON ================= --}}
                <div class="detail-action" id="detailAction"></div>
            </div>
        </div>
    </div>
</div>
