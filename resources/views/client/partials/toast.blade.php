<div class="toast-wrapper toast-success shadow-lg p-3">

    <div class="d-flex align-items-center gap-3">
        <ion-icon name="checkmark-circle-outline" class="fs-1" style="color: #13d16c;"></ion-icon>
        <div class="text">
            <h5 class="fw-semibold" style="color: #13d16c;">Success</h5>
            <span class="message-success text-wrap fw-semibold">
                {{ session('msg') }}
            </span>
        </div>
    </div>
    <div class="toast-close" onclick="closeToast()">✖</div>

    <div class="toast-progress progress-success"></div>
</div>