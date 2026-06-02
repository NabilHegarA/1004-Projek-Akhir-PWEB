{{-- REJECT MODAL --}}
<div class="reject-modal-overlay" id="rejectModal">

    <div class="reject-modal-box">

        <button
            class="reject-close"
            onclick="closeRejectModal()"
        >
            ✕
        </button>

        <h3>Alasan Penolakan</h3>

        <form
            id="rejectForm"
            method="POST"
        >
            @csrf

            <textarea
                name="rejection_reason"
                class="reject-textarea"
                placeholder="Masukkan alasan penolakan..."
                required
            ></textarea>

            <button
                type="submit"
                class="btn reject-btn"
                onclick="saveTab('pending')"
            >
                Kirim Penolakan
            </button>

        </form>

    </div>

</div>
