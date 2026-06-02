{{-- MODAL DETAIL LAPAK --}}
<div id="lapakModal">

    <div class="lapak-modal-content">

        <button
            onclick="closeLapakModal()"
            class="lapak-close"
        >
            ✕
        </button>

        <div class="lapak-modal-grid">

            <img
                id="modalLapakImg"
                class="lapak-modal-img"
                src=""
            >

            <div>

                <h2
                    id="modalLapakNama"
                    class="lapak-modal-title"
                ></h2>

                <div class="lapak-detail-group">

                    <div>
                        <p class="lapak-label">Jenis</p>
                        <p id="modalLapakJenis"></p>
                    </div>

                    <div>
                        <p class="lapak-label">Harga</p>
                        <p id="modalLapakHarga"></p>
                    </div>

                    <div>
                        <p class="lapak-label">Deskripsi</p>

                        <div
                            id="modalLapakDesc"
                            class="lapak-desc-box"
                        ></div>
                    </div>

                    <div>
                        <p class="lapak-label">Status</p>
                        <p id="modalLapakStatus"></p>
                    </div>

                </div>

                @isset($isAdmin)
                <a id="modalEditBtn" class="lapak-edit-btn" href="#">
                    Edit Lapak
                </a>
                @endisset

                @unless(isset($isAdmin))
                <a id="modalBookingBtn" class="lapak-booking-btn" href="#">
                    Booking Sekarang
                </a>
                @endunless

            </div>

        </div>

    </div>

</div>
